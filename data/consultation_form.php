<?php
    // Запуск сессий
    session_start();

    // Выборка данных из формы
    $name = $_POST["name"];
    $phone = $_POST["phone"];

    // Validation
    if (empty($name) || empty($phone)) {
        $_SESSION["error-name"] = "Введите данные";
        $_SESSION["error-phone"] = "Введите данные";
        header("Location: index.php");
        exit;
    } else if (strlen($name) < 2) {
        $_SESSION["error-name"] = "Ваше имя слишком короткое";
        header("Location: index.php");
        exit;
    } else if (!preg_match('/^\+?\d{10,15}$/', $phone)) {
        $_SESSION["error-phone"] = "Некоректный номер телефона";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION["success"] = "Спасибо за заявку! Мы скоро с вами свяжимся";
        header("Location: index.php");
        exit;
    }