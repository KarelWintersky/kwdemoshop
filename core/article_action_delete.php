<?php
require_once "lib_core.php";

$link = ConnectDB();
$id = $_GET["id"];
$q = "UPDATE ".$CONFIG['table_articles']." SET deleted=1 WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается пометить статью на удаление! [$q]");
CloseDB($link);
$article["deleted"] = 1;
printf("Статья помечена на удаление<br>\n");
?>
<div name="UnDeleteАrticle" style="<?php if ($article["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
    <input type="button" name="bUnDeleteArticle" value='Снять пометку "на удаление"'
           onClick="showAnyFile('article_action_undelete.php?id=<?php echo $id ?>','remove_controls')">
</div>

<br>

<div name="PurgeArticle" style="<?php if ($article["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
    <input type="button" name="bPurgeArticle" value='Окончательно удалить статью из базы'
           onClick="showAnyFile('article_action_purge.php?id=<?php echo $id ?>','remove_controls')">
</div>

