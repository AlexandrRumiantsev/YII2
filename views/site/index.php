<?php

// выводим код шапки 
include_once('header.php');

?>

		
		<!-- Начало блока популярных товаров -->
		<div class="panel panel-default popular-products">
		  <div class="panel-heading">
			<h3 class="panel-title">Товары</h3>
		  </div>
		  <div class="panel-body">
			<?php
			if($products){
			    foreach ($products as $m){
					$baseUrl=Yii::$app->request->baseUrl;
					$name = $m -> name;
					$id = $m -> id;
					$price = $m -> price ;
			echo"
				<div style='padding-top:20px;' class='popular-item col-xs-12 col-sm-4 col-md-4 col-lg-4'>
					<h4><a href='product.php?id=$id'>$name</a></h4>
					<img  src='$baseUrl/images/$id.jpg' />
					<span>$price руб.</span>					
					<a class='btn btn-primary' href='?r=site%2Forders&id=$id'>В корзину</a>	
				</div>";}
			}
			?>
		  </div>
		</div>
		<!-- Конец блока популярных товаров -->
		
