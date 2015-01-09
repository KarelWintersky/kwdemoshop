<?php
require_once "lib_core.php";
$link = ConnectDB();

$qa = array (
    'time_create' => time(),
    'time_modify' => time(),
    'title' => mysql_real_escape_string($_POST["ArticleTitle"]),
    'user_create' => $_SESSION["userinfo"]["id"],
    'user_modify' => $_SESSION["userinfo"]["id"],
    'body' => mysql_real_escape_string($_POST["ArticleText"]),
    'display_count' => 0,
    'relation' => 0   // FIX01: Требуется исправление article_add.php (добавления поля)
    // + справочник ref_ar (article relations)
);
$qstr = MakeInsert($qa, 'articles');
$res = mysql_query($qstr,$link) or Die("Невозможно сохранить статью в БД!".$q);
$new_id = mysql_insert_id() or Die("Невозможно получить id последней записи из БД!");
mysql_close($link);
?>
<head>
    <script type="text/javascript" src="kernel.js"></script>
</head>
<body>
<div>
    Статья добавлена<br>
    <a href="#" onClick="link_to_article(<?php echo $new_id; ?>)">Получить ссылку</a><br>
    <input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='articles.php'" />

</div>
<div id="a_preview">
    &nbsp;
</div>
</body>
