<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Функция валидации телефона
function validatePhone($phone) {
    // Очищаем номер от лишних символов
    $cleanedPhone = preg_replace('/[^0-9+]/', '', $phone);
    
    // Проверяем формат номера
    return preg_match('/^\+?7[0-9]{10}$/', $cleanedPhone);
}

// Получаем ID пользователя
$user_id = (int)$_SESSION['id'];
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

// Подключаемся к базе данных
include("dbconnect.php");

try {
    // Валидируем номер телефона
    if (!validatePhone($phone)) {
        die('Неверный формат номера телефона. Используйте формат +7XXXXXXXXXX');
    }

    // Проверяем существование пользователя
    $sql = "SELECT id, email FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die('Пользователь с ID ' . $user_id . ' не найден в базе данных');
    }

    // Получаем данные пользователя
    $user = $result->fetch_assoc();
    $email = $user['email'];

    // Получаем остальные данные
    $name_user = $_SESSION['login'] ?? '';
    $product_sum = $_SESSION['cart.sum'] ?? 0;

    // Проверяем обязательные поля
    if (empty($name_user) || empty($email) || empty($product_sum)) {
        die('Не все данные для заказа заполнены');
    }

    // Форматируем номер телефона для хранения
    $formattedPhone = '+7' . substr($phone, 1);

    // Создаем заказ
    $sql = "INSERT INTO orders (name_user, email, phone, sum) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssd", $name_user, $email, $formattedPhone, $product_sum);

    if ($stmt->execute()) {
        echo "<h2 style='text-align:center;'>Заказ успешно оформлен!</h2><br>
        <h3 style='text-align:center;'>Менеджер свяжется с вами для уточнения деталей заказа.
        <a href='../index.php'>Вернуться на главную</a></h3>";

        // Очищаем корзину
        unset($_SESSION['cart']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.qty']);
    } else {
        echo "Ошибка при создании заказа: " . $stmt->error;
    }

} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage();
} finally {
    if ($stmt) {
        $stmt->close();
    }
    $mysqli->close();
}
?>
