<?php
// Создание структуры Базы Данных гостевой книги
	define("DB_HOST", "localhost");
	define("DB_LOGIN", "root");
	define("DB_PASSWORD", "rQLevE4");
	define("DB_NAME", "eshop");

	$dbConnection1 = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysqli_error());

	$sql = "CREATE DATABASE ".DB_NAME;
	mysqli_query($dbConnection1, $sql) or die(mysqli_error());

	// mysqli_select_db(DB_NAME) or die(mysqli_error());

	$dbConnection2 = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_error());

	$sql = "
		CREATE TABLE catalog (
			id int(11) NOT NULL auto_increment,
			author varchar(50) NOT NULL default '',
			title varchar(50) NOT NULL default '',
			pubyear int(4) NOT NULL default 0,
			price int(11) NOT NULL default 0,
			PRIMARY KEY (id)
		);";
	mysqli_query($dbConnection2, $sql) or die(mysqli_error());

	$sql = "
		CREATE TABLE basket (
			id int(11) NOT NULL auto_increment,
			customer varchar(32) NOT NULL default '',
			goodsid int(11) NOT NULL default 0,
			quantity int(4) NOT NULL default 0,
			datetime int(11) NOT NULL default 0,
			PRIMARY KEY (id)
		);";
	mysqli_query($dbConnection2, $sql) or die(mysqli_error());

	$sql = "
		CREATE TABLE orders (
			id int(11) NOT NULL auto_increment,
			author varchar(50) NOT NULL default '',
			title varchar(50) NOT NULL default '',
			pubyear int(4) NOT NULL default 0,
			price int(11) NOT NULL default 0,
			customer varchar(32) NOT NULL default '',
			quantity int(4) NOT NULL default 0,
			datetime int(11) NOT NULL default 0,
			PRIMARY KEY (id)
		);";
	mysqli_query($dbConnection2, $sql) or die(mysqli_error());

	mysqli_close($dbConnection2);
	mysqli_close($dbConnection1);

	print("<p>Структура базы данных успешно создана!</p>");
?>

