<?php
	// Подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
	/*
	ЗАДАНИЕ 1
	- Получите и отфильтруйте данные из формы

	ЗАДАНИЕ 2
	- Вызовите функцию save() для сохранения нового товара в БД
	*/

    $author = "";
    $title = "";
    $pubYear = 1970;
    $price = 100;

    // Получение и фильтрация данных из формы (1)
    // Сохранение нового товара в БД (2)
    if(!empty($_POST["author"]) && !empty($_POST["title"]) && !empty($_POST["pubyear"]) && !empty($_POST["price"])){

        // (1)
        $author = clearData($dbConnection, $_POST["author"]);
        $title = clearData($dbConnection, $_POST["title"]);
        $pubYear = clearData($dbConnection, $_POST["pubyear"], "int");
        $price = clearData($dbConnection, $_POST["price"], "int");

        // (2)
        save($dbConnection, $author, $title, $pubYear, $price);

	}

    /*
	ЗАДАНИЕ 3
	- Переадресуйте пользователя на страницу добавления нового товара (add2cat.php)
	*/
    header("Location: add2cat.php");

?>