<?php
require_once "lib_shop.php";
//
$id = $_GET["id"];
$link = ConnectDB();
$q = "UPDATE ".$CONFIG['table_market']." SET deleted=0 WHERE (id=$id)";
$result = mysql_query($q) or Die('Не удается снять пометку "на удаление"!');
print("Пометка на удаление снята!<br>\n");
$entry["deleted"] = 0;
CloseDB($link);
?>
<div name="DeleteGoods" style="<?php if ($entry["deleted"]==0) echo 'display: block'; else echo 'display: none'?>">
    <input type="button" name="bDeleteGoods" value="Пометить товар на удаление"
           onClick="showAnyFile('goods_action_delete.php?id=<?php echo $id ?>','remove_controls')">
</div>

<br>


