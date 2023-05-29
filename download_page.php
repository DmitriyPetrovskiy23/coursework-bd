<?php
session_start();
require_once("config/database_connect.php");
if ($_SESSION["name"] === true) {
    $title = 'Загрузка фото';
    include("inc/header.php");
} else {
    header("location: index.php");
    exit;
}
?>

<body>
    <?php
    //Проверка на существование в таблице photos данных о текущем пользователе
    $user_id = $_SESSION["user_id"];
    $status = 0;
    $statement = $pdo->prepare("SELECT user_id FROM photos WHERE user_id = :user_id");
    $result = $statement->execute(array('user_id' => $user_id));
    $users_id = $statement->fetchAll();

    if (!empty($users_id)) :
        $statement = $pdo->prepare("SELECT user_id, status, path_photo FROM photos WHERE user_id = :user_id");
        $result = $statement->execute(array('user_id' => $user_id));
        $user_status = $statement->fetch();
        $path_photo = $user_status['path_photo'];
    ?>
        <div class="img-parent">
            <img src="<?php echo ($path_photo) ?>" class="img-center">
            <?php if ($user_status['status'] == 0) : ?>
                <div class="img-status img-moder">
                    Ваше фото на модерации<br>
                    Ожидайте изменения статуса
                </div>
            <?php else : ?>
                <div class="img-status img-yes">
                    Ваше фото утверждено
                </div>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <form action="controllers/save_photo.php"" class=" form-download-foto" method="post" enctype="multipart/form-data">
            <div class="input-file-container">
                <input class="input-file" id="my-file" name="fileToUpload" type="file" accept="image/png, image/jpeg">
                <label tabindex="0" for="my-file" class="input-file-trigger">Выбрать фото</label>
            </div>
            <p class="file-return"></p>
            <button type="submit" name="submit" class="submit-foto">Сохранить фото</button>
        </form>
        <script>
            document.querySelector("html").classList.add('js');

            var fileInput = document.querySelector(".input-file"),
                button = document.querySelector(".input-file-trigger"),
                the_return = document.querySelector(".file-return"),
                submitFoto = document.querySelector(".submit-foto");

            button.addEventListener("keydown", function(event) {
                if (event.keyCode == 13 || event.keyCode == 32) {
                    fileInput.focus();
                }
            });
            button.addEventListener("click", function(event) {
                fileInput.focus();
                return false;
            });
            fileInput.addEventListener("change", function(event) {
                the_return.innerHTML = this.value;
                submitFoto.style.display = 'block';
            });
        </script>


    <?php endif; ?>
</body>

</html>