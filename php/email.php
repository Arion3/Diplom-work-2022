
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Восстановление пароля</title>
</head>
<body>
    <form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="post">
        <p>Введите ваш EMail: <input type="email" name="email"></p>
        <p><input type="submit" value="Отправить" name="doGo"></p>
    </form>
</body>
</html>

<?php 
include ("dbconnect.php");
if (isset($_REQUEST['doGo'])) {
    // Проверка что email введён
    if ($_REQUEST['email']) {
        $email = $_REQUEST['email'];
        
        // хешируем хеш, который состоит из email и времени
        $hash = md5(rand(1,99));
        
        // Переменная $headers нужна для Email заголовка
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$email>\r\n";
        $headers .= "From: <mail@example.com>\r\n";
        // Сообщение для Email
        $message = '
                <html>
                <head>
                <title>Подтвердите Email</title>
                </head>
                <body>
                <p>Что бы восстановить пароль перейдите по <a href="http://example.com/newpass.php?hash=' . $hash . '">ссылка</a></p>
                </body>
                </html>
                ';
        
        // Меняем хеш в БД
        mysqli_query("UPDATE `users` SET hash='$hash' WHERE email='$email'");
        // проверка отправилась ли почта
        if (mail($email, "Восстановление пароля через Email", $message, $headers)) {
            // Если да, то выводит сообщение
            echo 'Ссылка для восстановления пароля отправленная на вашу почту';
        } else {
            echo 'Произошла какая то ошибка, письмо отправилось';
        }
    } else {
        // Если ошибка есть, то выводить её 
        echo "Вы не ввели Email"; 
    }
}
?>
