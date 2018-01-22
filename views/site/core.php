<?php
/**
Вспомогательные функции для шаблон orders.php
Который выводит список товаров в корзине
ЗЫ временный костыль, необходимо найти эквивалент в YII
**/

session_start(); 

	mysql_connect('localhost', 'root', '');
	mysql_select_db('electroshop');
	mysql_set_charset('utf8');

	

function query($sql)
{
	$result = mysql_query($sql);
	$error = mysql_error(); 
	if ($error != '') { 
		echo $error;
		echo ' в SQL-запросе:', $sql;
		exit();		
	}
	return $result; 
}


function getDBResult($sql)
{
	$result = query($sql);
	if (is_resource($result)) {
		return mysql_fetch_assoc($result);
	} else {
		return 0;
	}
}

function getDBResults($sql)
{
	$results = query($sql);
	if (is_resource($results)) {
		while ($row = mysql_fetch_assoc($results)) {
			$rows[] = $row;
			
		}
		return $rows;
	} else {
		return 0;
	}
}