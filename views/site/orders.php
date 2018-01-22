<?php

require_once('core.php');


if ($_GET['del_id'] > 0)  {
	$del_id = (int) $_GET['del_id'];
	unset($_SESSION['cart'][$del_id]); 
	redirect('cart.php'); 
}

if ($_GET['id']) {
	$id = (int)	$_GET['id'];

	
	if ($_SESSION['cart'][$id] > 0) {
		
		$_SESSION['cart'][$id] = $_SESSION['cart'][$id] + 1;
	} else { 
		$_SESSION['cart'][$id] = 1;
	}
}
	

	
	if (count($_SESSION['cart']) > 0) {
		foreach ($_SESSION['cart'] as $product_id => $counts) {
			$ids[] = $product_id;
		}
		$rows = getDBResults("SELECT * FROM `products` WHERE id IN (" . implode(',', $ids) . ")");
	}

	
	if ($POST['id']) {
	echo "Заказ успешно оформлен!";}
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
					
				</tr>
				<?php if (count($rows) > 0) { ?>
				<?php foreach ($rows as $key => $row) { ?>
				<tr>
					<td><?php echo ($key+1); ?></td>
					<td><img style="height: 50px;" src="<?php echo Yii::$app->request->baseUrl; ?>/images/<?php echo $row['id']; ?>.jpg" /></td>
					<td><a href="product.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
					<td><?php echo $row['price']; ?></td>
					<td><?php echo $_SESSION['cart'][$row['id']]; ?></td>
					<td><?php
					$sum = $sum + ($_SESSION['cart'][$row['id']] * $row['price']);
					echo $_SESSION['cart'][$row['id']] * $row['price']; ?></td>
					
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
		  <form  style="margin:10px; display:none;" method="post" action="/web/index.php?r=site%2Fsuccess">
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
			  <input type="hidden" name="orders" value="<?$row['price'];$row['name'];?>" />
			  <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
			  <input type="submit" class="btn btn-success" value="Подтвердить заказ >">
		  </form>
		</div>
		<?php } ?>