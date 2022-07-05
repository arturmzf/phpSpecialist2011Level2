<?php
	// Запуск сессии
	session_start();
	// Подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
?>

<html>
    <head>
        <title>Каталог товаров</title>
    </head>
<body>
<?php
/*
ЗАДАНИЕ 1
- Выведите в этом месте строку "Товаров в корзине: "
	и текущее количество товаров в корзине для
	данного пользователя
- Слово "корзине" оформите в виде гиперссылки на
	документ basket.php
*/
?>
<p>Товаров в <a href="basket.php">корзине</a>: <?=$count?></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>Автор</th>
	<th>Название</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>В корзину</th>
</tr>
<?php
	/*
	ЗАДАНИЕ 2
	- С помощью функции selectAll() получите выборку всех товаров
	- В цикле выведите все товары на экран
	- Значение ячейки "В корзину" оформите в виде гиперссылки на
	документ add2basket.php, добавив параметр id с идентификатором(поле id) товара
	*/

    $goodsList = array();
    $goodsList = selectAll($dbConnection);

    foreach($goodsList as $row){

        echo("<tr>");

        echo("<td>".$row["author"]."</td>");
        echo("<td>".$row["title"]."</td>");
        echo("<td>".$row["pubyear"]."</td>");
        echo("<td>".$row["price"]."</td>");
        echo("<td><a href=\"add2basket.php?id=".$row["id"]."\">В корзину</a></td>");

        /*
        foreach($row as $item){

            echo("<td>".$item."</td>");

        }
        */

        echo("</tr>");

    }

?>
</table>
</body>
</html>