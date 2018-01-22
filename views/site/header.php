<!DOCTYPE html>
<html>
<head>
	<title>Товары</title>
	<meta charset="utf-8" />

	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- подключаем наши стили -->
	<link href="style.css" rel="stylesheet" />
</head>
<body>	


	<!-- скрываем шапку сайта при отображении на мобильных за счет класса: hidden-xs -->
	<header class="row hidden-xs">
		<!-- Логотип и слоган -->
		<div class="logo col-xs-12 col-sm-4 col-md-4 col-lg-4">
			
			<span>Учебная разработка. Каталог товаров.</span>
		</div>
		<!-- Блок с контактной инфорацией -->
		<div id="contacts" class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding-right:200px;">
			<p><b>+7(927) 530-84-51</b></p>
			<p>г. Волгоград</p>
			<p>r-sasha@list.ru</p>
		</div>		
		<!-- Блок корзины -->
		<div id="cart" class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding-left:250px;">
			<div>
				<?php
				
				$ids = @array_keys($_SESSION['cart']); 
				if (count($ids) > 0) {
					
					if (count($products) > 0) { 
						foreach ($products as $row) { 
							
							$totalCount = $totalCount + $_SESSION['cart'][$row['id']];
							$totalSum = $totalSum + ($_SESSION['cart'][$row['id']] * $row['price']);
						}
					}
				}
				?>
				<p>Товаров: <?php echo (int) $totalCount; ?></p>
				<p>На сумму: <?php echo (int) $totalSum; ?> р.</p>
				
			</div>
			
		</div>
	</header>