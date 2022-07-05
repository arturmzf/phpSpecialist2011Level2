<?php
    /* ЗАДАНИЕ 1
    - Подключитесь к серверу mySQL
    - Выберите активную Базу Данных 'gbook'
    - Проверьте, была ли корректным образом отправлена форма
    - Если она была отправлена: отфильтруйте полученные данные,
      сформируйте SQL-оператор на вставку данных в таблицу msgs
      и выполните его. После этого выполните перезапрос страницы, чтобы избавиться от информации, переданной через форму
    */

    define("DB_HOST", "localhost");
    define("DB_LOGIN", "root");
    define("DB_PASS", "rQLevE4");
    define("DB_TITLE", "gbook");

    $dbConnection = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASS, DB_TITLE);

    // Функция/метод обрабатывает введённые пользователем данные, преобразуя её в корректную форму
    function clearData($inputData, $type = "string"){

        switch($type){
            case "string":
                return trim(strip_tags($inputData));
                break;
            case "int":
                return abs((int)$inputData);
                break;
        }




    }

    /*
    $dbHost = "localhost";
    $dbLogin = "root";
    $dbPass = "rQLevE4";
    $db = "gbook";
    $dbConnection = mysqli_connect($dbHost, $dbLogin, $dbPass, $db);
    */

    if(!(empty($_POST["name"])) && !(empty($_POST["email"]))) {
        $name = clearData($_POST["name"]);
        $email = clearData($_POST["email"]);
        $msg = clearData($_POST["msg"]);

        $sql = "INSERT INTO msgs (name, email, msg) VALUES ('".$name."', '".$email."', '".$msg."');";
        mysqli_query($dbConnection, $sql);

        header("Location: gbook.php");
        exit;
    } elseif(($_POST["name"] == "") && ($_POST["email"] != "")){
        echo("Вы не заполнили поле Имя");
        header("Location: gbook.php");
    } elseif(($_POST["name"] != "") && ($_POST["email"] == "")){
        echo("Вы не заполнили поле E-Mail");
        header("Location: gbook.php");
    }

    // Удаление поста
    if(isset($_GET["del"])){

        $id = clearData($_GET["del"], "int");

        if($id > 0){

            $sql = "DELETE FROM msgs WHERE ID = '".$id."';";
            mysqli_query($dbConnection, $sql);

        }

    }

    //if(!(is_empty($_POST["name"])) && !(is_empty($_POST["email"])))

    /*
    if($_POST["name"] && $_POST["email"] && $_POST["msg"]){
        echo("Успех!");
    } else{
        echo("Чего-то не очень...");
    }
    */

    /*
    ЗАДАНИЕ 3
    - Проверьте, был ли запрос методом GET на удаление записи
    - Если он был: отфильтруйте полученные данные,
      сформируйте SQL-оператор на удаление записи и выполните его.
      После этого выполните перезапрос страницы, чтобы избавиться от информации, переданной методом GET
    */

?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Гостевая книга</title>
        <meta charset="utf-8" />
    </head>
    <body>

        <h1>Гостевая книга</h1>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

            Ваше имя:<br />
            <input type="text" name="name" /><br />
            Ваш E-mail:<br />
            <input type="text" name="email" /><br />
            Сообщение:<br />
            <textarea name="msg" cols="50" rows="5"></textarea><br />
            <br />
            <input type="submit" value="Добавить!" />

        </form>

        <?php
            /*
            ЗАДАНИЕ 2
            - Сформируйте SQL-оператор на выборку всех данных из таблицы
              msgs в обратном порядке и выполните его. Результат выборки
              сохраните в переменной.
            - Закройте соединение с БД
            - Получите количество рядов результата выборки и выведите его на экран
            - В цикле получите очередной ряд результата выборки в виде ассоциативного массива.
              Таким образом, используя этот цикл, выведите на экран все сообщения, а также информацию
              об авторе каждого сообщения. После каджого сообщения сформируйте ссылку для удаления этой
              записи. Информацию об идентификаторе удаляемого сообщения передавайте методом GET.
            */

            $sql = "SELECT * FROM msgs ORDER BY id DESC;";
            $dataFromDBObject = mysqli_query($dbConnection, $sql) or die(mysqli_error());
            $notesAmount = mysqli_num_rows($dataFromDBObject);

            echo("<br /><p>Всего записей в гостевой книге: ".$notesAmount."</p>");
            mysqli_close($dbConnection);
            echo("<br />");
            echo("<hr />");
            echo("<br />");

            for($i = 0; $i < $notesAmount; $i++){

                $dataFromDBAssoc = mysqli_fetch_assoc($dataFromDBObject);
                $id = $dataFromDBAssoc["id"];
                $name = $dataFromDBAssoc["name"];
                $email = $dataFromDBAssoc["email"];
                $msg = nl2br($dataFromDBAssoc["msg"]);

                if(($name == null) && ($email == null) && ($msg == null)){
                    continue;
                }

                echo("<b><a href=\"mailto:".$email."\">".$name."</a></b>");
                echo("<br />");
                echo("<br />");
                echo("<i>".$email."</i>");
                echo("<br />");
                echo("<br />");
                echo("<i>".$msg."</i>");
                echo("<p align=\"right\">");
                echo("<a href=\"".$_SERVER['PHP_SELF']."?del=".$id."\">Удалить</a>");
                echo("</p>");
                echo("<br />");
                echo("<br />");
                echo("<hr />");

            }

        ?>

    </body>
</html>