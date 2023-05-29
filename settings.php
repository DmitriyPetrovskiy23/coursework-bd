<?php
session_start();
require_once("config/database_connect.php");
if ($_SESSION["name"] === true && $_SESSION['rights_group'] == 1) {
    $title = 'Настройки';
    include("inc/header.php");
} else {
    header("location: index.php");
    exit;
}
?>

<body>
    <main class="container container-settings">
        <div class="settings_rights">
            <?php
            //Получаем все возможные права пользователей
            $statement = $pdo->prepare('SELECT * FROM rights_users');
            $statement->execute();
            $rights = $statement->fetchAll();
            ?>
            <table class="table table-settings">
                <thead>
                    <tr>
                        <th>Название группы прав</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rights as $right) : ?>
                        <tr>
                            <?php if (count($rights) == 1) : ?>
                                <td><?php echo ($right['name']) ?></td>
                            <?php else : ?>
                                <td><?php echo ($right['name']) ?> <a href='<?php echo ("controllers/settings.php?right=" . $right['id']) ?>' class="delete-param">Удалить</a></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form action="controllers/settings.php" method="post" class="form-addparam">
                <input type="text" name="right" class="input-param">
                <button type="submit" class="button-param btn btn-primary">Добавить</button>
            </form>
        </div>
        <div class="settings_structural_division">
            <?php
            //Получаем все возможные структурные подразделения пользователей
            $statement = $pdo->prepare('SELECT * FROM structural_division_users');
            $statement->execute();
            $structural_divisions = $statement->fetchAll();
            ?>
            <table class="table table-settings">
                <thead>
                    <tr>
                        <th>Названия структурных подразделений</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($structural_divisions as $structural_division) : ?>
                        <tr>
                            <?php if (count($structural_divisions) == 1) : ?>
                                <td><?php echo ($structural_division['name']) ?></td>
                            <?php else : ?>
                                <td><?php echo ($structural_division['name']) ?> <a href='<?php echo ("controllers/settings.php?structural_division=" . $structural_division['id']) ?>' class="delete-param">Удалить</a></td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form action="controllers/settings.php" method="post" class="form-addparam">
                <input type="text" name="structural_division" class="input-param">
                <button type="submit" class="button-param btn btn-primary">Добавить</button>
            </form>
        </div>
    </main>
    <div class="container container-settings-users">
        <h1 class="header-changeusers">Управление зарегестрированными пользователями</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Группа прав</th>
                    <th>Структурное подразделение</th>
                    <th>Email</th>
                    <th>Управление</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $statement = $pdo->prepare('SELECT id, surname, name, patronymic, email, structural_division, rights_group FROM users');
                $statement->execute();
                $users = $statement->fetchAll();
                //Вывод каждого пользователя у которого есть фото
                foreach ($users as $key_user => $user) :
                    $statement = $pdo->prepare('SELECT * FROM rights_users WHERE id = :id');
                    $statement->execute(array('id' => $user['rights_group']));
                    $right = $statement->fetch();
                ?>
                    <tr>
                        <td><?php echo ($user['surname'] . " " . $user['name'] . " " . $user['patronymic']) ?></td>
                        <td><?php echo ($right['name']) ?></td>
                        <td><?php echo ($user['structural_division']) ?></td>
                        <td><?php echo ($user['email']) ?></td>
                        <td>
                            <a href="<?php echo ("edituser_page.php?id=" . $user['id']) ?>" class="btn btn-success">Редактирование</a>
                            <a href="<?php echo ("controllers/functions_user.php?id=" . $user['id'] . "&delete=" . $user['id']) ?>" class="btn btn-danger">Удалить</a>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>