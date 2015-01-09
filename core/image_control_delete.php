<?php
require_once "lib_gd.php";
$id=$_GET["id"];
//
$link = ConnectDB();
$result = mysql_query("UPDATE imagelist SET deleted=1 WHERE (id=$id)") or Die("Не удается пометить изображение на удаление!");
CloseDB($link);
$image["deleted"] = 1;
printf("Изображение помечено на удаление<br>\n");
?>
<div name="UnDeleteImage" style="<?php if ($image["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
    <input type="button" name="bUnDeleteImage" value='Снять пометку "на удаление"'
           onClick="showAnyFile('image_control_undelete.php?id=<?php echo $id ?>','remove_controls')">
</div>

<br>

<div name="PurgeImage" style="<?php if ($image["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
    <input type="button" name="bPurgeImage" value='Окончательно удалить изображение из базы'
           onClick="showAnyFile('image_control_purge.php?id=<?php echo $id ?>','remove_controls')">
</div>



