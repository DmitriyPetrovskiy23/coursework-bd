<?php
session_start();
require_once("config/database_connect.php");
if ($_SESSION["name"] === true && $_SESSION['rights_group'] == 1) {
    $title = 'Редактирование пользователя';
    include("inc/header.php");
} else {
    header("location: index.php");
    exit;
}
$id = $_GET['id'];
$statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$statement->execute(array('id' => $id));
$user = $statement->fetch();
?>

<body>
    <div class="container container-edit-user">
        <h1 class="header-edit-user">Редактирование пользователя</h1>
        <form action="<?php echo('controllers/settings.php?id='.$id) ?>" class="form-edit-user" method="post">
            <input type="text" name="surname" placeholder="Фамилия" value="<?php echo($user['surname'])?>" required class="input-edit-user"/>
            <input type="text" name="name" placeholder="Имя" value="<?php echo($user['name'])?>" required class="input-edit-user"/>
            <input type="text" name="patronymic" placeholder="Отчество" value="<?php echo($user['patronymic'])?>" class="input-edit-user"/>
            <select name="rights_group" required class="input-edit-user">
                <option value="" selected disabled hidden class="header_select">Группа прав</option>
                <?php
                require_once("config/database_connect.php");
                //Получаем все возможные группы прав для пользователей
                $statement = $pdo->prepare('SELECT * FROM rights_users');
                $statement->execute();
                $rights = $statement->fetchAll();
                foreach ($rights as $right) :
                ?>
                    <?php if($user['rights_group'] == $right['id']):?>
                        <option value='<?php echo ($right['name']) ?>' selected><?php echo ($right['name']) ?></option>
                    <?php else: ?>
                        <option value='<?php echo ($right['name']) ?>'><?php echo ($right['name']) ?></option>
                    <?php endif;?>
                <?php endforeach; ?>
            </select>
            <select name="structural_division" required class="input-edit-user">
                <option value="" disabled hidden class="header_select">Подразделение</option>
                <?php
                require_once("config/database_connect.php");
                //Получаем все возможные структурные подразделения пользователей
                $statement = $pdo->prepare('SELECT * FROM structural_division_users');
                $statement->execute();
                $structural_divisions = $statement->fetchAll();
                foreach ($structural_divisions as $structural_division) :
                ?>
                    <?php if($user['structural_division'] == $structural_division['name']):?>
                        <option value='<?php echo ($structural_division['name']) ?>' selected><?php echo ($structural_division['name']) ?></option>
                    <?php else: ?>
                        <option value='<?php echo ($structural_division['name']) ?>'><?php echo ($structural_division['name']) ?></option>
                    <?php endif;?>
                <?php endforeach; ?>
            </select>
            <input type="text" name="email" placeholder="Email" value="<?php echo($user['email'])?>" required class="input-edit-user"/>
            <input type="text" name="phone" placeholder="Телефон" value="<?php echo($user['phone'])?>" required class="input-edit-user"/>
            <button type="submit" id="button-edit-user" name="button-edit-user">Отредактировать пользователя</button>
        </form>
    </div>
</body>

</html>