<?php 
session_start();
unset($_SESSION["name"]);
unset($_SESSION["user_id"]);
unset($_SESSION["rights_group"]);
header("location: index.php");
?>