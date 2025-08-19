<?php
// Включаем все ошибки
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Получаем данные из POST
$full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
$login = isset($_POST['login']) ? trim($_POST['login']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$rep_password = isset($_POST['rep_password']) ? trim($_POST['rep_password']) : '';

// Валидация обязательных полей
if (empty($login) || empty($password) || empty($email) || empty($full_name)) {
    die('Вы ввели не всю информацию, вернитесь назад и заполните все поля!');
}
if (strlen($login) < 3 || strlen($login) > 20) {
    die('Логин должен быть от 3 до 20 символов!');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Неверный формат email!');
}

// Проверка совпадения паролей
if ($password !== $rep_password) {
    die('Ошибка! Пароли не совпадают!');
}

// Подключение к БД
include("dbconnect.php");

// Защита от SQL-инъекций
$login = $mysqli->real_escape_string($login);
$full_name = $mysqli->real_escape_string($full_name);
$email = $mysqli->real_escape_string($email);

// Проверка существования пользователя
$result = $mysqli->query("SELECT login FROM users WHERE login = '$login'");
$myrow = $result->fetch_assoc();

if (!empty($myrow['login'])) {
    die("Введенный вами логин уже зарегистрирован. Введите другой логин.");
}

// Хеширование пароля
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Проверка длины перед вставкой
if (strlen($hashed_password) > 255) {
    die("Длина хеша пароля превышает допустимую");
}

// Вставка данных в БД
$sql = "INSERT INTO users (full_name, login, email, password) 
        VALUES ('$full_name', '$login', '$email', '$hashed_password')";

if ($mysqli->query($sql)) {
    echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт под своим именем. <a href='../index.php'>Главная страница</a>";
} else {
    die("Ошибка при регистрации: " . $mysqli->error);
}

// Закрываем соединение
$mysqli->close();
?>
