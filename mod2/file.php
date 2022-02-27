<?php
    /*
    ЗАДАНИЕ 1
    - Установите константу для хранения имени файла
    - Проверьте, отправлялась ли форма и корректно ли отправлены данные из формы
    - В случае, если форма была отправлена, отфильтруйте полученные значения
    - Сформируйте строку для записи с файл
    - Откройте соединение с файлом и запишите в него сформированную строку
    - Выполните перезапрос текущей страницы (чтобы избавиться от данных, отправленных методом POST)
    */

    define(FILENAME, "fl1.txt");
    $firstName = "";
    $lastName = "";
    $result = "";

    // if($_SERVER["REQUEST_METHOD"] == "POST"){|
    if(isset($_POST["fname"]) && $_POST["lname"]) {
        $firstName = trim(strip_tags($_POST["fname"]));
        $lastName = trim(strip_tags($_POST["lname"]));

        $result = $firstName." ".$lastName."\n";

        file_put_contents(FILENAME, $result, FILE_APPEND);

        header("LOCATION: file.php");
        exit(); // Лишнее же... Ну, да ладно...
    }

?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Работа с файлами</title>
        <meta charset="utf-8" />
    </head>
    <body>

        <h1>Заполните форму</h1>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            Имя: <input type="text" name="fname" /><br />
            Фамилия: <input type="text" name="lname" /><br />

            <br />

            <input type="submit" value="Отправить!" />

        </form>

        <?php
            /*
            ЗАДАНИЕ 2
            - Проверьте, существует ли файл с информацией о пользователях
            - Если файл существует, получите все содержимое файла в виде массива строк
            - В цикле выведите все строки данного файла с порядковым номером строки
            - После этого выведите размер файла в байтах.
            */
            $resultArray = array();
            if(file_exists(FILENAME)){
                $resultArray = file(FILENAME);

                // Вывод 1
                echo("<br />");
                $i = 1;
                foreach($resultArray as $data){
                    echo($i." ".$data."<br />");
                    $i++;
                }

                // Вывод 2 - то же, что и 3, только самописно :)
                if(is_array($resultArray)){
                    echo("<br />");
                    for($j = sizeof($resultArray); $j > 0; $j--) {
                        echo((sizeof($resultArray) - $j + 1) . " " . $resultArray[$j - 1] . "<br />");
                    }
                }

                // Вывод 3 - то же, что и 2, только с помощью PHP
                echo("<br />");
                $resultArrayReverse = array_reverse($resultArray);
                $k = 1;
                foreach($resultArrayReverse as $data){
                    echo($k." ".$data."<br />");
                    $k++;
                }

                echo("<br />");
                echo("Размер файла составляет: ".filesize(FILENAME)." байт.");
            }
        ?>

    </body>
</html>