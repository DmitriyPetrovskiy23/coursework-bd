<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/download_page.css">
    <link rel="stylesheet" href="../css/adminpanel.css">
    <link rel="stylesheet" href="../css/settings.css">
    <link rel="stylesheet" href="../css/edituser.css">
</head>

<header>
    <nav class="menu">
        <ul class="menu__list r-list">
            <li class="menu__group"><a href="/home.php" class="menu__link r-link text-underlined">Домой</a></li>
            <li class="menu__group"><a href="/download_page.php" class="menu__link r-link text-underlined">Загрузить фото</a></li>
            <?php
            //Проверяем права пользователя
            $id = $_SESSION["user_id"];
            $statement = $pdo->prepare('SELECT id, rights_group FROM users WHERE id = :id');
            $statement->execute(array('id' => $id));
            $right_group = $statement->fetch();
            $_SESSION['rights_group'] = $right_group['rights_group'];
            if($_SESSION['rights_group'] == 1):
            ?>
            <li class="menu__group"><a href="/adminpanel.php" class="menu__link r-link text-underlined">Панель Администратора</a></li>
            <li class="menu__group"><a href="/settings.php" class="menu__link r-link text-underlined">Настройки</a></li>
            <?php endif;?>
            <li class="menu__group"><a href="/logout.php" class="menu__link r-link text-underlined">Выход</a></li>
        </ul>
    </nav>
</header>