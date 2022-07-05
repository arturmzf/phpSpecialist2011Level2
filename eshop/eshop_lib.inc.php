<?php

    // Фильтрация входных данных
    function clearData($dbConnection, $data, $type = "string"){

        $clearedData = "";

        switch($type){

            case "string":
                $clearedData = mysqli_real_escape_string($dbConnection, trim(strip_tags($data)));
                // $clearedData = trim(strip_tags($data));
                break;
            case "stringForFile":
                $clearedData = trim(strip_tags($data));
                break;
            case "int":
            default:
            $clearedData = (int)($data);
                break;

        }

        return $clearedData;

    }


    /*
	ЗАДАНИЕ 1
	- Опишите функцию save(), сохраняющую новый товар в таблицу catalog
	- Функция должна принимать следующие значения:
			author
			title
			pubyear
			price

	*/

    // Сохраняет новый товар в таблицу catalog
    function save($dbConnection, $author, $title, $pubYear, $price){

        $sql = "INSERT INTO catalog (author, title, pubyear, price)
                    VALUES ('".$author."', '".$title."', '".$pubYear."', '".$price."');";
        echo($sql);
        // mysqli_query($dbConnection, $sql) or die(mysqli_error($dbConnection));
        mysqli_query($dbConnection, $sql);

    }
	
	/*
	ЗАДАНИЕ 2
	- Опишите функцию selectAll(), возвращающую все содержимое каталога товаров
	*/

    // Упаковываем данные в массив // 11 часть урока
    function db2Arr($rowsAmount, $resultDBResource){

        $resultArray = array($rowsAmount);

        for($i = 0; $i < $rowsAmount; $i++){

            $resultArray[$i] = mysqli_fetch_array($resultDBResource);

        }

        return $resultArray;

    }

    // Возврат всего содержимого каталога товаров
    function selectAll($dbConnection){

        $sql = "SELECT id, author, title, pubyear, price FROM catalog;";
        $resultResource = mysqli_query($dbConnection, $sql);
        $goodsAmount = mysqli_num_rows($resultResource);

        return db2Arr($goodsAmount, $resultResource);

    }

	/*
	ЗАДАНИЕ 3
	- Опишите функцию add2basket(), которая будет добавлять товары в корзину пользователя
	- Функция должна принимать следующие значения:
			customer
			goodsid
			quantity
			datetime
	*/

    function add2basket($dbConnection, $customer, $goodsid, $quantity, $datetime){

        $sql = "INSERT INTO basket (customer, goodsid, quantity, datetime)
                                VALUES('".$customer."', '".$goodsid."', '".$quantity."', '".$datetime."');";
        mysqli_query($dbConnection, $sql) or die(mysqli_error($dbConnection));

    }

	/*
	ЗАДАНИЕ 4
	- Опишите функцию myBasket(), которая будет возвращать всю пользовательскую корзину
	*/

    function myBasket($dbConnection){

        $sql = "SELECT author, title, pubyear, price, basket.id, goodsid, customer, quantity
                    FROM catalog,basket WHERE customer = '".session_id()."' AND catalog.id = basket.goodsid;";
        $resultResource = mysqli_query($dbConnection, $sql);
        $goodsAmount = mysqli_num_rows($resultResource);

        return db2Arr($goodsAmount, $resultResource);

    }

	/*
	ЗАДАНИЕ 5
	- Опишите функцию basketDel(), которая будет удалять товар из корзины пользователя
	- Функция должна принимать следующие значения:
			id
	*/

    function basketDel($dbConnection, $id){

        $sql = "DELETE FROM basket WHERE ID = '".$id."';";
        mysqli_query($dbConnection, $sql) or die(mysqli_error($dbConnection));

    }
	
	/*
	ЗАДАНИЕ 6
	- Опишите функцию resave() для пересохранения товаров из корзины (таблица basket) в заказы (таблица orders)
	- Функция должна принимать следующие значения:
			datetime – дата заказа 
	- Для получения содержимого корзины в этой функции воспользуйтесь функцией myBasket()
	- Опишите в функции resave() SQL-оператор, который будет вставлять данные из корзины в таблицу orders и выполните его
	- Опишите SQL-оператор для удаления данных о корзине текущего покупателя из таблицы basket
	*/

    function resave($dbConnection, $dateTime){

        // $goods = myBasket();
        // foreach($goods as $item) {}

        $sql = "SELECT goodsid, quantity FROM basket WHERE customer = '".session_id()."';";
        $goodsFromBasketAssocResource = mysqli_query($dbConnection, $sql);
        $amountOfGoodsFromBasket = mysqli_num_rows($goodsFromBasketAssocResource);

        for($i = 0; $i < $amountOfGoodsFromBasket; $i++){

            $goodsFromBasketAssoc = mysqli_fetch_assoc($goodsFromBasketAssocResource);

            $goodsID = $goodsFromBasketAssoc["goodsid"];
            $quantity = $goodsFromBasketAssoc["quantity"];

            $sql01 = "SELECT author, title, pubyear, price
                                FROM catalog
                                WHERE ID = '".$goodsID."';";
            $goodInfoAssoc = mysqli_fetch_assoc(mysqli_query($dbConnection, $sql01));

            $author = $goodInfoAssoc["author"];
            $title = $goodInfoAssoc["title"];
            $pubYear = $goodInfoAssoc["pubyear"];
            $price = $goodInfoAssoc["price"];

            $sql02 = "INSERT INTO orders
                                    (author, title, pubyear, price, customer, quantity, datetime)
                                    VALUES ('".$author."', '".$title."', '".$pubYear."', 
                                        '".$price."', '".session_id()."', '".$quantity."', '".$dateTime."');";
            mysqli_query($dbConnection, $sql02);

            $sql03 = "DELETE FROM basket WHERE customer = '".session_id()."';";
            mysqli_query($dbConnection, $sql03);

        }

    }

	/*
	ЗАДАНИЕ 7
	- Опишите функцию getOrders() для получения информации о заказах
	- Получите в виде массива $orders данные о пользователях из файла "orders.log"
	- Создайте массив $allorders для хранения информации обо всех заказах
	- В цикле foreach переберите все заказы
	- Внутри цикла foreach создайте ассоциативный массив $orderinfo для хранения информации о каждом конкретном заказе
	- Сохраните информацию о пользователе из массива $orders(name, email, phone, address, customer, date) в массиве $orderinfo
	- Опишите SQL-оператор для выборки из таблицы заказов всех товаров для конкретного покупателя
	- Получите весь результат этой выборки
	- Сохраните полученный в предыдущем пункте результат как значение
		ключа "goods" в массиве $orderinfo
	- Добавьте сформированный массив $orderinfo в виде значения очередного ключа массива $allorders
	- Функция getOrders() должна возвращать массив $allorders с информацией о всех покупателях
		и сделанных ими заказах
	*/

    function getOrders($dbConnection){

        if(file_exists(ORDERS_LOG)){

            // $parsedFile = fopen();

            $allOrders = array();
            $orders = file(ORDERS_LOG);

            foreach($orders as $order){

                list($name, $email, $phone, $address, $customer, $dateTime) = explode("|", $order);

                $orderInfo = array();

                $orderInfo["name"] = $name;
                $orderInfo["email"] = $email;
                $orderInfo["phone"] = $phone;
                $orderInfo["address"] = $address;
                $orderInfo["dateTime"] = $dateTime*1;

                $sql = "SELECT * FROM orders WHERE customer = '".$customer."' AND datetime = '".$orderInfo["dateTime"]."';";
                $result = mysqli_query($dbConnection, $sql) or die(mysqli_error($dbConnection));
                $amount = mysqli_num_rows($result);

                $orderInfo["goods"] = db2Arr($amount, $result);

                $allOrders[] = $orderInfo;

            }

        }else{

            return false;

        }

        return $allOrders;

    }

?>