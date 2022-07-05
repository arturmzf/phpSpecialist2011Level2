<?php
	/*
	ЗАДАНИЕ 1
	- Создайте четыре константы:
		DB_HOST - для хранения адреса сервера баз данных mySQL
		DB_LOGIN - для хранения логина для соединения с сервером баз данных mySQL
		DB_PASSWORD - для хранения пароля для соединения с сервером баз данных mySQL
		DB_NAME - для хранения имени базы данных
	- Создайте переменную $count, которая будет хранить количество товаров в корзине пользователя и присвойте ей значение по умолчанию
	- Создайте константу ORDERS_LOG, которая будет хранить имя файла с личными данными пользователей
	- Установите соединение с сервером баз данных mySQL, используя вышесозданные константы
	- Выберите на сервере для работы базу данных DB_NAME
	*/

    // Адрес сервера баз данных mySQL
    define("DB_HOST", "localhost");
    // Логин для соединения с сервером баз данных mySQL
    define("DB_LOGIN", "root");
    // Пароль для соединения с сервером баз данных mySQL
    define("DB_PASSWORD", "rQLevE4");
    // Имя базы данных
    define("DB_NAME", "eshop");

    // Переменная $count, которая будет хранить количество товаров в корзине пользователя
    $count = 0;

    // Имя файла с личными данными пользователей
    define("ORDERS_LOG", "orders.log");

    // Установка соединения с сервером баз данных mySQL, выбор на сервере для работы базы данных DB_NAME
    /*$dbConnection = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME)
                            or die("Невозможно соединиться с сервером БД: ".mysqli_error());*/
    $dbConnection = mysqli_connect("localhost", "root", "rQLevE4", "eshop")
                        or die("Невозможно соединиться с сервером БД");

    /*
	ЗАДАНИЕ 2
	- Выполните SQL-оператор на выборку количества товаров в корзине данного пользователя
	- Получите результат и сохраните его в значении переменной $count	
	*/

    $sql = "SELECT count(*) FROM basket WHERE customer = '".session_id()."';";
    $res = mysqli_query($dbConnection, $sql) or die(mysqli_error($dbConnection));
    $count = mysqli_fetch_assoc($res)["count(*)"];
    // $count = mysqli_result($res, 0, "count(*)");
    // $count = mysqli_free_result($res);

?>