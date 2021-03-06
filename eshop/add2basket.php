<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	/*
	ЗАДАНИЕ 1
	- Получите идентификатор конкретного покупателя
	- Получите идентификатор товара, добавляемого в корзину
	- Назначьте количество добавляемого товара равным 1
	- Получите дату добавления товара в корзину (текущую дату)
		в формате UNIX timestamp
	- Добавьте товар в корзину
	- Переадресуйте пользователя на каталог товаров
	*/

    $customer = session_id();
    $id = clearData($dbConnection, $_GET["id"], "int");
    $quantity = 1;
    $datetime = time();

    add2basket($dbConnection, $customer, $id, $quantity, $datetime);

    header("Location: catalog.php");

?>