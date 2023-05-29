<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/auth.css">
    <title>Вход</title>
</head>

<body>
    <div class="flex-block">
        <div class="login-page">
            <div class="form">
                <form class="register-form" action="controllers/register.php" method="post">
                    <input type="text" name="surname" placeholder="Фамилия" required />
                    <input type="text" name="name" placeholder="Имя" required />
                    <input type="text" name="patronymic" placeholder="Отчество" />
                    <select name="structural_division" required>
                        <option value="" selected disabled hidden class="header_select">Подразделение</option>
                        <?php
                        require_once("config/database_connect.php");
                        //Получаем все возможные структурные подразделения пользователей
                        $statement = $pdo->prepare('SELECT * FROM structural_division_users');
                        $statement->execute();
                        $structural_divisions = $statement->fetchAll();
                        foreach ($structural_divisions as $structural_division) :
                        ?>
                            <option value='<?php echo ($structural_division['name']) ?>'><?php echo ($structural_division['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="email" placeholder="Email" required />
                    <input type="text" name="phone" placeholder="Телефон" required />
                    <input type="password" name="password" placeholder="Пароль" required />
                    <button type="submit">Зарегестрироваться</button>
                    <p class="message">Уже зарегестрированы? <a href="#">Войти</a></p>
                </form>
                <form class="login-form" action="controllers/login.php" method="post">
                    <input type="text" name="email" placeholder="Email" required />
                    <input type="password" name="password" placeholder="Пароль" required />
                    <button type="submit">Войти</button>
                    <p class="message">Не зарегестрированы? <a href="#">Создать аккаунт</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/auth.js"></script>
</body>

</html>