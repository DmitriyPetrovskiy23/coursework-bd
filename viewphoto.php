<?php
session_start();
require_once("config/database_connect.php");
if ($_SESSION["name"] === true && $_SESSION['rights_group'] == 1) {
    $title = 'Просмотр фото';
    include("inc/header.php");
} else {
    header("location: index.php");
    exit;
}
if (isset($_GET['id_photo'])):
$id = $_GET['id_photo'];
//Получаем путь к фото
$statement = $pdo->prepare('SELECT id, path_photo FROM photos WHERE id = :id');
$statement->execute(array('id' => $id));
$photo_id_path = $statement->fetch();
?>
<body>
    <div class="img-parent">
        <img src='<?php echo($photo_id_path['path_photo'])?>' class="img-center">
    </div>
</body>
<?php else:?>
    <?php header("location: adminpanel.php");?>
<?php endif;?>