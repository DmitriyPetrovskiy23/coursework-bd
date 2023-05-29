<?php
session_start();
require_once("../config/database_connect.php");
header('Content-Type: text/html; charset=utf-8');

$id = $_GET['id'];
$statement = $pdo->prepare('SELECT * FROM photos WHERE id = :id');
$statement->execute(array('id' => $id));
$photo_id_path = $statement->fetch();

if (isset($_GET['success'])){
    $sql = "UPDATE photos SET status=? WHERE id=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([2, $id]);
} else if (isset($_GET['fail'])) {
    $sql = "UPDATE photos SET status=? WHERE id=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([1, $id]);
} else if (isset($_GET['delete'])) {
    unlink('../'.$photo_id_path['path_photo']);
    $sql = "DELETE FROM photos WHERE id=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$id]);
}

header("location: ../adminpanel.php");
exit;