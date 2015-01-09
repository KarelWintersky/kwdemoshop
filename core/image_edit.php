<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

require_once "lib_gd.php";
$id = $_GET["id"];
// like image_action.php?action=edit&id=..
// Calls image_edit.php?id=...
$image = LoadImageInfo($id);
?>
<html>
<head>
    <link type="text/css" rel="stylesheet" href="../main.css">
    <script type="text/javascript" src="kernel.js"></script>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">
</head>
<!-- <?php echo "IsDeleted: [".$image['deleted']."]" ?> -->
<body>
<a href="image_show.php?action=image&id=<?php echo $id?>" rel="lightbox"><img src="image_preview.php?id=<?php echo $id?>"/ title="Показать изображение в полный размер"></a>
<br>
<a href="javascript://" onClick="window.open('image_show.php?action=image&id=<?php echo $id?>','newwindow')"><small>Показать изображение в полный размер</small></a>

<br>
Отредактируйте описание, если необходимо:<br>
<form enctype="multipart/form-data" action="image_update.php?id=<?php echo $id?>" method="POST">
    <input type="hidden" name="image_id" value="<?php echo $id?>">
    <textarea cols="60" rows="3" wrap="virtual" name="comment"><?php echo $image['comment']?></textarea><br>
    <input type="submit" name="update" value="Обновить данные">
</form>

<div id="remove_controls">

    <div name="DeleteImage" style="<?php if ($image["deleted"]==0) echo 'display: block'; else echo 'display: none'?>">
        <input type="button" name="bDeleteImage" value="Пометить изображение на удаление"
               onClick="showAnyFile('image_control_delete.php?id=<?php echo $id ?>','remove_controls')">
    </div>

    <br>

    <div name="UnDeleteImage" style="<?php if ($image["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
        <input type="button" name="bUnDeleteImage" value='Снять пометку "на удаление"'
               onClick="showAnyFile('image_control_undelete.php?id=<?php echo $id ?>','remove_controls')">
    </div>

    <br>

    <div name="PurgeImage" style="<?php if ($image["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
        <input type="button" name="bPurgeImage" value='Окончательно удалить изображение из базы'
               onClick="showAnyFile('image_control_purge.php?id=<?php echo $id ?>','remove_controls')">
    </div>

</div>
<hr>
<br>
<!--   <input type="button" name="Return_to_gallery" value="Вернуться к галерее" onClick="document.location.href='image_list.php';return false;"> -->
<input type="button" name="Return_to_gallery" value="Вернуться к галерее" onClick="history.go(-1);return false;">
<!-- на самом деле не image_list.php а ссылка на нашего родителя... "кто вызвал скрипт" -->
<div id="edit_result">&nbsp;</div>
</body>
</html>

