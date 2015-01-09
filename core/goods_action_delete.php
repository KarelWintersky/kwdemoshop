<?php
require_once "lib_core.php";
//
$link = ConnectDB();
$id = $_GET["id"];
$q = "UPDATE ".$CONFIG['table_market']." SET deleted=1 WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается пометить товар на удаление! [$q]");
CloseDB($link);
$entry["deleted"] = 1;
printf("Товар помечен на удаление<br>\n");
?>
<div name="UnDeleteGoods" style="<?php if ($entry["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
    <input type="button" name="bUnDeleteGoods" value='Снять пометку "на удаление"'
           onClick="showAnyFile('goods_action_undelete.php?id=<?php echo $id ?>','remove_controls')">
</div>

<br>

<div name="PurgeGoods" style="<?php if ($entry["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
    <input type="button" name="bPurgeGoods" value='Окончательно удалить товар из базы'
           onClick="showAnyFile('goods_action_purge.php?id=<?php echo $id ?>','remove_controls')">
</div>
<br/>