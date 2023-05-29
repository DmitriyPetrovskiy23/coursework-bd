<?php
session_start();
require_once("../config/database_connect.php");
header('Content-Type: text/html; charset=utf-8');

$target_dir = "../photo/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if (isset($_POST["submit"])) {
    $photo = $_FILES["fileToUpload"]["name"];
    $photo_tmp_name = $_FILES["fileToUpload"]["tmp_name"];

    //Подготовка данных для вставки в таблицу photos
    $user_id = $_SESSION["user_id"];
    $path_photo = "photo/". basename($_FILES["fileToUpload"]["name"]);
    $imagick = new Imagick();
    $imagick->readImage($photo_tmp_name);
    $resolution = $imagick->getImageResolution()['x'];

    $file_size = $imagick->getImageLength() / 1024;
    $width = $imagick->getImageGeometry()['width'];
    $length = $imagick->getImageGeometry()['height'];
    $format = mb_strtoupper(ltrim(stristr($_FILES["fileToUpload"]["type"], "/"), "/"));
    $status = 0;

    //Занесение данных в таблицу photos
    $statement = $pdo->prepare("INSERT INTO photos (user_id, path_photo, resolution, file_size, width, length, format, status) VALUES (:user_id, :path_photo, :resolution, :file_size, :width, :length, :format, :status)");
    $result = $statement->execute(array('user_id' => $user_id, 'path_photo' => $path_photo, 'resolution' => $resolution, 'file_size' => $file_size, 'width' => $width, 'length' => $length, 'format' => $format, 'status' => $status));
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}

header("location: ../download_page.php");
exit;
