<?php
require_once "lib_core.php";
//
$link = ConnectDB();
$id = $_GET["id"];
$q = "UPDATE ".$CONFIG['table_offers']." SET deleted=1 WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается пометить статью на удаление! [$q]");
CloseDB($link);
$offer["deleted"] = 1;
printf("Запись помечена на удаление<br>\n");
?>
<div name="UnDeleteOffer" style="<?php if ($offer["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
    <input type="button" name="bUnDeleteOffer" value='Снять пометку "на удаление"'
           onClick="showAnyFile('offer_action_undelete.php?id=<?php echo $id ?>','remove_controls')">
</div>

<br>

<div name="PurgeOffer" style="<?php if ($offer["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
    <input type="button" name="bPurgeOffer" value='Окончательно удалить запись из базы'
           onClick="showAnyFile('offer_action_purge.php?id=<?php echo $id ?>','remove_controls')">
</div>
<br><br>

