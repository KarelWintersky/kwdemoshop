<?php
require_once "lib_core.php";
//
$id = $_GET["id"];
$link = ConnectDB();
$q = "UPDATE ".$CONFIG['table_offers']." SET deleted=0 WHERE (id=$id)";
$result = mysql_query($q) or Die('Не удается снять пометку "на удаление"!');
print("Пометка на удаление снята!<br>\n");
$offer["deleted"] = 0;
CloseDB($link);
?>
<div name="DeleteOffer" style="<?php if ($offer["deleted"]==0) echo 'display: block'; else echo 'display: none'?>">
    <input type="button" name="bDeleteOffer" value="Пометить запись на удаление"
           onClick="showAnyFile('offer_action_delete.php?id=<?php echo $id ?>','remove_controls')">
</div>
<br>
<br>


