<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
?>
<html>
<head>
	<title>Поступившие заказы</title>
</head>
<body>
<h2>Поступившие заказы:</h2>
<?php

/*
    ЗАДАНИЕ 1
    - вызовите функцию getOrders() и сохраните результат её работы
        в переменную
    - используя цикл foreach выведите информацию обо всех заказах,
        используя указанную ниже шапку
    */

    $allOrders = getOrders($dbConnection);

    if(is_array($allOrders)) {

        foreach($allOrders as $order){

            $name = $order["name"];
            $email = $order["email"];
            $phone = $order["phone"];
            $address = $order["address"];
            $dateTime = date("d.m.Y H:i:s", $order["dateTime"]);

            $goodsInfo = $order["goods"];

            echo("<hr />");
            echo("<p><b>Заказчик</b>: ".$name."</p>");
            echo("<p><b>Email</b>: ".$email."</p>");
            echo("<p><b>Телефон</b>: ".$phone."</p>");
            echo("<p><b>Адрес доставки</b>: ".$address."</p>");
            echo("<p><b>Дата размещения заказа</b>: ".$dateTime."</p>");

            echo("<h3>Купленные товары:</h3>");
            echo("<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\" width=\"90%\">");

            echo("<tr>");
            echo("<th>N п/п</th>");
            echo("<th>Автор</th>");
            echo("<th>Название</th>");
            echo("<th>Год издания</th>");
            echo("<th>Цена, руб.</th>");
            echo("<th>Количество</th>");
            echo("</tr>");

            $number = 1;
            $resultPriceSum = 0;

            foreach($goodsInfo as $good){

                $author = $good["author"];
                $title = $good["title"];
                $pubYear = $good["pubyear"];
                $price = $good["price"];
                $quantity = $good["quantity"];

                echo("<tr>");
                echo("<td>".$number.".</td>");
                echo("<td>".$author."</td>");
                echo("<td>".$title."</td>");
                echo("<td>".$pubYear."</td>");
                echo("<td>".$price."</td>");
                echo("<td>".$quantity."</td>");
                echo("</tr>");

                $number++;

                $resultPriceSum += ($price * $quantity);

            }

            echo("</table>");
            echo("<br />");
            echo("<p>Всего товаров в заказе на сумму: ".$resultPriceSum." руб.</p>");
            echo("<br />");

        }

    }else{

        echo("<p>Заказов ещё не было...</p>");

    }

?>


<br />
<br />
<br />
<h4>Блок для примера</h4>
<hr />
<p><b>Заказчик</b>: </p>
<p><b>Email</b>: </p>
<p><b>Телефон</b>: </p>
<p><b>Адрес доставки</b>: </p>
<p><b>Дата размещения заказа</b>: </p>
<h3>Купленные товары:</h3>
<table border="1" cellpadding="5" cellspacing="0" width="90%">
<tr>
	<th>N п/п</th>
	<th>Автор</th>
	<th>Название</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
</tr>

</table>
<p>Всего товаров в заказе на сумму: руб.</p>


</body>
</html>