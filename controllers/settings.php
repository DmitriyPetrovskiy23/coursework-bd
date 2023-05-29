<?php
session_start();
require_once("../config/database_connect.php");


if (isset($_POST['button-edit-user'])) {
    $id = $_GET['id'];
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $rights_group = $_POST['rights_group'];

    //Получить id группы прав
    $statement = $pdo->prepare('SELECT * FROM rights_users WHERE name = :name');
    $statement->execute(array('name' => $rights_group));
    $rights = $statement->fetch();
    $rights_id = $rights['id'];

    $structural_division = $_POST['structural_division'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE users SET surname=?, name=?, patronymic=?, rights_group=?, structural_division=?, email=?, phone=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$surname, $name, $patronymic, $rights_id, $structural_division, $email, $phone, $id]);
} else {
    if (isset($_POST["right"])) {
        $name = $_POST["right"];
        $sql = "INSERT INTO rights_users (name) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name]);
    } else if (isset($_POST["structural_division"])) {
        $name = $_POST["structural_division"];
        $sql = "INSERT INTO structural_division_users (name) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name]);
    }

    if (isset($_GET['structural_division'])) {
        $id = $_GET['structural_division'];
        $sql = "DELETE FROM structural_division_users WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    } else if (isset($_GET['right'])) {
        $id = $_GET['right'];
        $sql = "DELETE FROM rights_users WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}

header("location: ../settings.php");
exit;
