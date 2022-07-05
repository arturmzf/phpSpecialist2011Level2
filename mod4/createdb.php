<?php
    // Создание структуры Базы Данных гостевой книги

    define("DB_HOST", "localhost");
    define("DB_LOGIN", "root");
    define("DB_PASSWORD", "rQLevE4");

    /*
    Функция mysql_connect() устарела
    mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysqli_error());

    $sql = 'CREATE DATABASE gbook';
    mysqli_query($sql) or die(mysqli_error());

    mysqli_select_db('gbook') or die(mysqli_error());
    */

    $dbConnect = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, "gbook") or die(mysqli_error($dbConnect));

    $sql = "
    CREATE TABLE msgs (
        id int(11) NOT NULL auto_increment,
        name varchar(50) NOT NULL default '',
        email varchar(50) NOT NULL default '',
        msg TEXT,
        PRIMARY KEY (id)
    )";

    mysqli_query($dbConnect, $sql) or die(mysqli_error($dbConnect));

    mysqli_close($dbConnect);

    print '<p>Структура базы данных успешно создана!</p>';
?>