<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
?>
<html>
<head>
	<title>Корзина пользователя</title>
</head>
<body>
<?php
	/*
	ЗАДАНИЕ 1
	- Проверьте, есть ли товары в корзине пользователя
	- Если товаров нет, выводите строку "Корзина пуста!"
	- Если товары есть, выводите их в нижеприведенной таблице
	*/

    if($count){

        echo("<a href=\"catalog.php\">Вернуться в каталог</a>");

    }else{

        echo("<p>Корзина пуста...</p><br />");
        echo("<a href=\"catalog.php\">Вернуться в каталог</a>");

    }

?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Автор</th>
	<th>Название</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<?php
	/*
	ЗАДАНИЕ 2
	- Получите все товары из корзины пользователя в виде массива
	- Создайте переменные для подсчета порядковых номеров ($i)
		и общей суммы заказа ($sum)
	- В цикле выводите все позиции из корзины на экран
	- Также, в цикле увеличивайте значение переменной $sum
		на соответствующее значение
		(сумма текущего товара * его количество)
	- Значение ячейки "Удалить" оформите в виде гиперссылки на
	документ delete_from_basket.php, добавив параметр id с id записи	
	*/

    $goodsInBasket = array();

    $goodsInBasket = myBasket($dbConnection);

    $number = 1;
    $sum = 0;

    foreach($goodsInBasket as $item){

        echo("<tr>");
        echo("<td>".$number."</td>");
        echo("<td>".$item["author"]."</td>");
        echo("<td>".$item["title"]."</td>");
        echo("<td>".$item["pubyear"]."</td>");
        echo("<td>".$item["price"]."</td>");
        echo("<td>".$item["quantity"]."</td>");
        echo("<td><a href=\"delete_from_basket.php?id=".$item["id"]."\">Удалить из корзины</a></td>");
        echo("</tr>");

        $number++;
        $sum += $item["price"]*$item["quantity"];

    }

?>
</table>

<p>Всего товаров в корзине на сумму:
<?php
	/*
	ЗАДАНИЕ 3
	- Выведите общую сумму товаров в корзине
	*/
    echo($sum." ");
?>
руб.
</p>
<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='orderform.php'">
</div>

</body>
</html>







