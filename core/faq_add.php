<?php
session_start();

if (!$_SESSION['is_admin']) header("Location: ../index.php");

require_once "lib_core.php";

?>
<head>
    <title>Редактор: консультация</title>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">

    <script src="/core/js/core.js"></script>
    <script src="/core/js/tinymce/tinymce.min.js"></script>
    <script src="/core/js/tinymce.config.js"></script>
    <script type="text/javascript">
        tinify(tiny_config['full'], 'FAQ_Answer');
    </script>

</head>

<body>
<b>Вы работаете от имени пользователя: <?php echo $_SESSION["userinfo"]['username']; ?></b><br>
<b>Добавьте пожалуйста консультационную статью:</b> <br><br>
<form action="faq_action_insert.php" method="post">
    Введите вопрос врачу:
    <input type="text" name="FAQ_Question" maxlen="50" size="100"><br>

    <textarea name="FAQ_Answer" id="FAQ_Answer" cols="10" tabindex="3"></textarea>

    <input type="hidden" name="caller" value="admin">
    <input type="submit" value="Сохранить" name="saveThis">
</form>
<input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='faq.php'" />
</body>