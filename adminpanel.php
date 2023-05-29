<?php
session_start();
require_once("config/database_connect.php");
if ($_SESSION["name"] === true && $_SESSION['rights_group'] == 1) {
    $title = 'Панель Администратора';
    include("inc/header.php");
} else {
    header("location: index.php");
    exit;
}

//Проверяем есть ли пользователи, которые загружали фотографии
$statement = $pdo->prepare('SELECT id, user_id, status FROM photos');
$statement->execute();
$users_download_photo = $statement->fetchAll();

if (empty($users_download_photo)) :
?>

    <body>
        <h1 class="header-no-photo">Фотографий нет</h1>
    </body>
<?php
else :

?>

    <body>
        <main class="container">
            <div class="table-parent">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Структурное подразделение</th>
                            <th>Фото</th>
                            <th>Статус фото</th>
                            <th>Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Вывод каждого пользователя у которого есть фото
                        foreach ($users_download_photo as $key_user => $user_download_photo) :
                            $user_id = $user_download_photo['user_id'];
                            $statement = $pdo->prepare('SELECT id, surname, name, patronymic, structural_division FROM users WHERE id = :user_id');
                            $statement->execute(array('user_id' => $user_id));
                            $user = $statement->fetch();
                        ?>
                            <tr>
                                <td><?php echo ($user['surname'] . " " . $user['name'] . " " . $user['patronymic']) ?></td>
                                <td><?php echo ($user['structural_division']) ?></td>
                                <td>
                                    <a href='<?php echo ("/viewphoto.php?id_photo=".$user_download_photo['id']) ?>' class="link-foto">Просмотр фото</a>
                                </td>
                                <td>
                                    <?php if($user_download_photo['status'] == 0):?>
                                        <span class="text-moderation">На модерации</span>
                                    <?php elseif($user_download_photo['status'] == 1):?>
                                        <span class="text-no">Отказано</span>
                                    <?php else:?>
                                        <span class="text-success">Утверждено</span>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <a href="<?php echo ("controllers/functions_photo.php?id=" .$user_download_photo['id']."&success=".$user_download_photo['id']) ?>" class="btn btn-success">Утвердить фото</a>
                                    <a href="<?php echo ("controllers/functions_photo.php?id=" .$user_download_photo['id']."&fail=".$user_download_photo['id']) ?>" class="btn btn-primary">Отказать фото</a>
                                    <a href="<?php echo ("controllers/functions_photo.php?id=" .$user_download_photo['id']."&delete=".$user_download_photo['id']) ?>" class="btn btn-danger">Удалить фото</a>
                                </td>
                            </tr>
                        <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </body>
<?php endif; ?>

</html>