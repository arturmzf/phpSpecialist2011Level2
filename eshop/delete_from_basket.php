<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	
	/*
	ЗАДАНИЕ 1
	- Получите идентификатор удаляемого товара
	- Вызовите функцию basketDel() для данного товара
	- Переадресуйте пользователя на корзину заказов
	*/

    $id = clearData($dbConnection, $_GET["id"], "int");

    basketDel($dbConnection, $id);

    header("Location: basket.php");

?>