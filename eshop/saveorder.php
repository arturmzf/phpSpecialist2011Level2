<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	/*
	ЗАДАНИЕ 1
	- получите из формы и обработайте данные заказа

	<p>Заказчик: <input type="text" name="name" size="50">
		<p>Email заказчика: <input type="text" name="email"
					size="50">
		<p>Телефон для связи: <input type="text" name="phone"
						size="50">
		<p>Адрес доставки: <br><textarea name="address"
                                     cols="50" rows="5"></textarea>
	*/

    /*
    $name = clearData($dbConnection, $_POST["name"]);
    $email = clearData($dbConnection, $_POST["email"]);
    $phone = clearData($dbConnection, $_POST["phone"]);
    $address = clearData($dbConnection, $_POST["address"]);
    */

    $name = clearData($dbConnection, $_POST["name"], "stringForFile");
    $email = clearData($dbConnection, $_POST["email"], "stringForFile");
    $phone = clearData($dbConnection, $_POST["phone"], "stringForFile");
    $address = clearData($dbConnection, $_POST["address"], "stringForFile");

    /*
	ЗАДАНИЕ 2
	- создайте переменную $order
	- создайте строку из полученных данных, разделяя их символом "|", например: "Иван Иванов|ivan@mail.ru|123-12-23|Москва, Сумской пр-д 17 кв.105"
	- присвойте созданную строку переменной $order
	- запишите значение переменной $order в файл orders.log
	  ВНИМАНИЕ: в зависимости от того, каким образом будет производиться работа с файлом, возможно, будет необходимо проверить существование файла orders.log. Новые данные должны записываться в конец файла!
	- сохраните файл
    */

    $dateTime = time();
    $order = $name."|".$email."|".$phone."|".$address."|".session_id()."|".$dateTime."\n";

    // file_put_contents(ORDERS_LOG, $order, FILE_APPEND); // Наиболее оптимальный способ
    // Но я решил сделать по-своему :)
    $file = fopen(ORDERS_LOG, "a+");
    fwrite($file, $order);
    fclose($file);
	
	/*
    ЗАДАНИЕ 3
	- вызовите функцию resave() для пересохранения купленных товаров из корзины
		в таблицу orders
	*/

    resave($dbConnection, $dateTime);

?>
<html>
<head>
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Каталог товаров</a></p>
</body>
</html>