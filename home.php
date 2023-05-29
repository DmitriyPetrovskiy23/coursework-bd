<?php
session_start();
require_once("config/database_connect.php");
if ($_SESSION["name"] === true) {
    $title = 'Домашняя страница';
    include("inc/header.php");
} else {
    header("location: index.php");
    exit;
}
?>
<body>
    <div class="container-home">
        <h1 class="header-home">Сервис по загрузке фотографий</h1>
    </div>
</body>

</html>