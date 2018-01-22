<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Cart';
//$this->params['breadcrumbs'][] = $this->title;
?>

<?php
// Страница корзины
require_once('core.php');

// если пользователь нажал на ссылку удалить напротив товара на странице Корзина
if ($_GET['del_id'] > 0)  {
	$del_id = (int) $_GET['del_id'];
	unset($_SESSION['cart'][$del_id]); // данная функция удалит элемент массива $_SESSION['cart'] с индексом хранящемся в значении переменной $_GET['del_id'] - таким образом мы удалим товар из корзины!
	redirect('cart.php'); // обязательно делаем редирект на http://electroshop/cart.php - потому что пользователь попадет сюда по ссылке например: http://electroshop/cart.php?del_id=1 - и если мы не переадресуем его на адрес корзины без ?del_id=1, то пользователь может случайно или нет обновить страницу с адресом: http://electroshop/cart.php?del_id=1 - при этом данный функционал попробует повторно удалить уже несуществующий элемент в массиве $_SESSION['cart'] - чего лучше не делать!
}

if ($_GET['id']) {
	$id = (int)	$_GET['id'];
	// добавляем товар в корзину, корзину временно сохраняем в качестве элементов массива $_SESSION['cart'], при этом в качестве ключе массива у нас id товара, а в качестве значения - кол-во товара в корзине, т.е. $_SESSION['cart'][1 ] = 5; - буквально будет значить: в корзин 5 штук товара с id = 1

	
	if ($_SESSION['cart'][$id] > 0) {
		// если товар уже добавлен (есть) в корзине, то просто увеличиваем его кол-во на 1 шт
		$_SESSION['cart'][$id] = $_SESSION['cart'][$id] + 1;
	} else { // если же товара еще нет, то добавляем его в корзину в размере 1 штуки
		$_SESSION['cart'][$id] = 1;
	}
}
	
	if (count($_SESSION['cart']) > 0) {
		foreach ($_SESSION['cart'] as $product_id => $counts) {
			$ids[] = $product_id;
		}
		$rows = getDBResults("SELECT * FROM `products` WHERE id IN (" . implode(',', $ids) . ")");
	}
	
	// в данном запросе нам необходимо получить все продукты, которые у нас добавлены в корзину, т.е. id которых находятся в $_SESSION['cart'], выше мы все эти id вытащили из $_SESSION['cart'] и записали в качестве значения в массив $ids
	// а здесь мы создали запрос вида: SELECT * FROM `products` WHERE id IN (1,2,4)
	// где 1,2,4 - это id товаров информацию о которых мы хотим получить, потому мы используем IN - чтобы передать сразу несколько id в условия SQL-запроса WHERE id
	// функция implode('разделитель', $массив) - выдает строку, помещая в неёё значения всех элементов массива разделяя их разделителем - который указывается первым параметром её.
	
	// чтобы проверить как выглядит массив вместо echo - которое просто выдаст Array, можно использовать функцию print_r() - которая покажет не просто массив а все его ключи и значения элементов
	//print_r($rows);

// выводим код шапки 
include_once('header.php');

// выводим код левой колонки сайта
include_once('sidebar.php');

?>
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title">Корзина</h3>
		  </div>
		  <div class="panel-body">
			<table class="table">
				<tr>
					<th>№</th>
					<th></th>
					<th>Наименование товара</th>
					<th>Цена</th>
					<th>Кол-во</th>
					<th>Сумма</th>
					<th>Удалить</th>
				</tr>
				<?php if (count($rows) > 0) { ?>
				<?php foreach ($rows as $key => $row) { ?>
				<tr>
					<td><?php echo ($key+1); ?></td>
					<td><img style="height: 50px;" src="/images/<?php echo $row['id']; ?>.jpg" /></td>
					<td><a href="product.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
					<td><?php echo $row['price']; ?></td>
					<td><?php echo $_SESSION['cart'][$row['id']]; ?></td>
					<td><?php
					$sum = $sum + ($_SESSION['cart'][$row['id']] * $row['price']);
					echo $_SESSION['cart'][$row['id']] * $row['price']; ?></td>
					<td><a href="cart.php?del_id=<?php echo $row['id']; ?>">удалить?</a></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="6" align="center"><br />В Корзине нет товаров!</td>
				</tr>
				<?php } ?>
			</table>
			<b>ИТОГО: 
			<?php 
				echo (int) $sum;
			?> руб.</b>
		  </div>
		</div>
		<?php if ($sum > 0) { ?>
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title">Оформление заказа</h3>
		  </div>
		  <div class="panel-body">
			<a class="btn btn-primary" onclick="$('form').show();$(this).hide();">Оформить заказ</a>
		  </div>
		  <form role="form" style="margin:10px; display:none;" method="post" action="order.php">
			  <div class="form-group">
				<label>Ваше Имя *</label>
				<input type="text" class="form-control" name="name">
			  </div>
			  <div class="form-group">
				<label>E-mail *</label>
				<input type="email" class="form-control" name="email">
			  </div>
			  <div class="form-group">
				<label>Телефон *</label>
				<input type="text" class="form-control" name="phone">
			  </div>
			  <div class="form-group">
				<label>Комментарий к заказу (необязательно!)</label>
				<textarea class="form-control" name="comment" style="height: 80px;"></textarea>
			  </div>
			  <input type="submit" class="btn btn-success" value="Подтвердить заказ >">
		  </form>
		</div>
		<?php } ?>
	
<?php

// выводим код подвала
include_once('footer.php');