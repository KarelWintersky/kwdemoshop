<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: /index.php");

require_once "lib_core.php";
?>
<head>
    <title>Редактор: статьи</title>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">
    <script src="/core/js/core.js"></script>
    <script src="/core/js/tinymce/tinymce.min.js"></script>
    <script src="/core/js/tinymce.config.js"></script>
    <script type="text/javascript">
        tinify(tiny_config['full'], 'area1');
    </script>

</head>

<body>
<b>Добавьте пожалуйста новую статью:</b> <br><br>
<form action="article_action_insert.php" method="post">
    Заголовок статьи: <input type="text" name="ArticleTitle" maxlen="50" size="100"><br>

    <textarea name="ArticleText" id="area1" cols="10" tabindex="3"></textarea>

    <input type="hidden" name="TheMagicNumber" value="<?php echo $magic; ?>">
    <input type="submit" value="Сохранить" name="saveThis">
</form>
<input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='articles.php'" />
</body>
