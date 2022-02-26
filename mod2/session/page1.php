<?php
    // Открываем сессию
    session_start();

    // Подключаем код для сохранения информации о странице в сессии
    include('savepage.inc.php');
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Страница 1</title>
        <meta charset="utf-8" />
    </head>
    <body>

        <h1>Страница 1</h1>

        <?php
            // Подключаем меню
            include('menu.inc.php');

            // Подключаем код для вывода информации обо всех посещенных страницах
            include('visited.inc.php');
        ?>

    </body>
</html>