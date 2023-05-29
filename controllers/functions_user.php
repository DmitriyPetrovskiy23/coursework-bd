<?php
session_start();
require_once("../config/database_connect.php");
header('Content-Type: text/html; charset=utf-8');

$id = $_GET['id'];

$statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$statement->execute(array('id' => $id));
$photo_id_path = $statement->fetch();

if (isset($_GET['delete'])) {
    $sql = "DELETE FROM users WHERE id=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$id]);
}

header("location: ../settings.php");
exit;
