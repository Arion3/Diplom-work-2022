<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Получаем данные из POST
$login = isset($_POST['login']) ? trim($_POST['login']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Валидация обязательных полей
if (empty($login) || empty($password)) {
    exit("<h2 style='text-align:center;'>Вы ввели не всю информацию, вернитесь назад и заполните все поля! <a href='login in.php'>Назад</a></h2>");
}

// Подключение к БД
include("dbconnect.php");

// Защита от SQL-инъекций
$login = $mysqli->real_escape_string($login);

// Получаем данные пользователя
$result = $mysqli->query("SELECT * FROM users WHERE login = '$login'");
$myrow = $result->fetch_assoc();

if (empty($myrow)) {
    exit("<h2 style='text-align:center;'>Введенный вами Логин или Пароль неверный. <a href='login in.php'>Назад</a></h2>");
} else {
    // Проверяем пароль через password_verify
    if (password_verify($password, $myrow['password'])) {
        // Пароль верный, сохраняем сессию
        $_SESSION['login'] = $myrow['login'];
        $_SESSION['id'] = $myrow['id'];
        
        if (!empty($_SESSION['cart'])) {
            echo "<h2 style='text-align:center;'>Вы успешно вошли на сайт!</h2>
            <br> <h3 style='text-align:center;'><a href='../catalog/zakaz.php'>Продолжить оформление заказа</a>
            <p><a href='../index.php'>Главная страница</a></p>
            <p><a href='../catalog.php'>Каталог</a></p></h3>";
        } else {
            echo "<h2 style='text-align:center;'>Вы успешно вошли на сайт!</h2>
            <h3 style='text-align:center;'><p><a href='../index.php'>Главная страница</a></p>
            <p><a href='../catalog.php'>Каталог</a></p></h3>";
        }
    } else {
        echo "<h2 style='text-align:center;'>Неверный пароль или логин. <a href='login in.php'>Назад</a></h2>";
    }
}
?>



