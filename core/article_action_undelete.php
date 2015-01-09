<?php
require_once "lib_core.php";
//  global $CONFIG;
//
$id = $_GET["id"];
$link = ConnectDB();
$q = "UPDATE ".$CONFIG['table_articles']." SET deleted=0 WHERE (id=$id)";
$result = mysql_query($q) or Die('Не удается снять пометку "на удаление"!');
print("Пометка на удаление снята!<br>\n");
$article["deleted"] = 0;
CloseDB($link);
?>
<div name="DeleteArticle" style="<?php if ($article["deleted"]==0) echo 'display: block'; else echo 'display: none'?>">
    <input type="button" name="bDeleteArticle" value="Пометить статью на удаление"
           onClick="showAnyFile('article_action_delete.php?id=<?php echo $id ?>','remove_controls')">
</div>

<br />



