<?php

require_once("../config/database_connect.php");

$error = false;

$surname = $_POST['surname'];
$name = $_POST['name'];
$patronymic = $_POST['patronymic'];
$structural_division = $_POST['structural_division'];
$password = $_POST['password'];
$email = $_POST['email'];
$phone = $_POST['phone'];

if (empty($surname) || empty($name)) {
    if (empty($surname) && empty($name)) {
        $message = "фамилию и имя";
    } else if (empty($surname)) {
        $message = "фамилию";
    } else {
        $message = "имя";
    }
    echo 'Введите ' . $message;
    $error = true;
}


if (!$error) {
    //Делаем хэш пароля
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    //!Регистрация пользователя
    $statement = $pdo->prepare("INSERT INTO users (surname, name, patronymic, structural_division, email, phone, password) VALUES (:surname, :name, :patronymic, :structural_division, :email, :phone, :password)");
    $result = $statement->execute(array('surname' => $surname, 'name' => $name, 'patronymic' => $patronymic, 'structural_division' => $structural_division, 'email' => $email, 'phone' => $phone, 'password' => $password_hash));
    header("location: ../home.php");
    exit;
}
