<?php
session_start();
require_once("../config/database_connect.php");
$error_msg = "";
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
    $user_id = $user['id'];
    $rights_group = $user['rights_group'];
    if ($user !== false && password_verify($password, $user['password'])) {
        $_SESSION["name"] = true;
        $_SESSION["user_id"] = $user_id;
        header("location: ../home.php");
        exit;
    }
} else {
    $error_msg =  "Email или Пароль неверны";
}
