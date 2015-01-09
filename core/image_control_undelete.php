<?php
require_once "lib_gd.php";
$id=$_GET["id"];
//
$link = ConnectDB();
$result = mysql_query("UPDATE imagelist SET deleted=0 WHERE (id=$id)") or Die('Не удается снять пометку "на удаление"!');
print("Пометка на удаление снята!<br>\n");
$image["deleted"] = 0;
CloseDB($link);
?>

<div name="DeleteImage" style="<?php if ($image["deleted"]==0) echo 'display: block'; else echo 'display: none'?>">
    <input type="button" name="bDeleteImage" value="Пометить изображение на удаление"
           onClick="showAnyFile('image_control_delete.php?id=<?php echo $id ?>','remove_controls')">
</div>
<br>


