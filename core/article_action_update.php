<?php
require_once "lib_core.php";
$link = ConnectDB();
$id = $_GET["id"];
$article["body"] = mysql_real_escape_string($_POST["ArticleText"]);
$article["title"] = mysql_real_escape_string($_POST["ArticleTitle"]);
$article["time_modify"] = time();
// брать данные из сессии админа
$article["user_modify"] = $_SESSION["userinfo"]["id"];

mysql_query($q="UPDATE articles SET time_modify='".$article["time_modify"]."' WHERE id=$id") or Die("Не удается изменить дату доступа ".$q);
mysql_query("UPDATE articles SET user_modify='".$article["user_modify"]."' WHERE id=$id") or Die("Не удается изменить информацию о доступе");
mysql_query("UPDATE articles SET title='".$article["title"]."' WHERE id=$id") or Die("Не удается изменить заголовок статьи");
mysql_query("UPDATE articles SET body='".$article["body"]."' WHERE id=$id") or Die("Не удается изменить содержимое статьи");
mysql_close($link);
?>
<head>
    <script type="text/javascript" src="kernel.js"></script>
</head>
<body>
<div>
    Статья изменена<br>

    <a href="#" onClick="link_to_article(<?php echo $id ?>)">Получить ссылку</a><br>
    <input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='articles.php'" />

</div>
<div id="a_preview">
    &nbsp;
</div>


</body>
