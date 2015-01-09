<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

require_once "lib_core.php";
// редактировать имеющуюся статью
$id = $_GET["id"];
$link = ConnectDB() or Die("Не удается соединиться с базой данных!");
$content = mysql_query("SELECT * FROM articles WHERE (id=$id)") or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
$article = mysql_fetch_assoc($content) or Die("Не удается получить результат запроса ($q)");
CloseDB($link);
?>
<head>
    <link type="text/css" rel="stylesheet" href="../main.css">
    <script type="text/javascript" src="kernel.js"></script>
    <script src="/core/js/core.js"></script>
    <script src="/core/js/tinymce/tinymce.min.js"></script>
    <script src="/core/js/tinymce.config.js"></script>
    <script type="text/javascript">
        tinify(tiny_config['full'], 'area1');
    </script>

</head>
<body>
<b>Отредактируйте пожалуйста статью:</b> <br><br>
<form action="article_action_update.php?id=<?php echo $id; ?>" method="post">
    Заголовок статьи: <input type="text" name="ArticleTitle" maxlen="50" size="100" value='<?php echo stripslashes($article["title"]); ?>'><br>

    <textarea name="ArticleText" id="area1" cols="10" tabindex="3"><?php echo $article['body']; ?></textarea>

    <input type="submit" value="Сохранить" name="saveThis">
</form>

<div id="remove_controls">

    <div name="DeleteArticle" style="<?php if ($article["deleted"]==0) echo 'display: block'; else echo 'display: none'?>">
        <input type="button" name="bDeleteArticle" value="Пометить статью на удаление"
               onClick="showAnyFile('article_action_delete.php?id=<?php echo $id ?>','remove_controls')">
    </div>

    <br>

    <div name="UnDeleteАrticle" style="<?php if ($article["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
        <input type="button" name="bUnDeleteArticle" value='Снять пометку "на удаление"'
               onClick="showAnyFile('article_action_undelete.php?id=<?php echo $id ?>','remove_controls')">
    </div>

    <br>

    <div name="PurgeArticle" style="<?php if ($article["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
        <input type="button" name="bPurgeArticle" value='Окончательно удалить статью из базы'
               onClick="showAnyFile('article_action_purge.php?id=<?php echo $id ?>','remove_controls')">
    </div>

</div>


<input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='articles.php'" />
</body>






