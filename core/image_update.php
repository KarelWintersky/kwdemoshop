<?php
require_once "lib_gd.php";
$link = ConnectDB();
$id = $_GET['id'];
$q = "UPDATE ".$CONFIG['table_images']." SET comment='".$_POST["comment"]."' WHERE (id=$id)";
$res = mysql_query($q,$link) or Die("Невозможно обновить данные");
CloseDB($link);
// надо вывести сообщение "успешно, через 3 секунды вас вернет обратно"
header("Location: image_edit.php?id=".$_GET['id']);
// перейти на аякс....
/*
<html>
<head>
<script type="text/javascript" defer>
window.setTimeout("document.location.href='image_edit.php?id='", 2000);
</script>
</head>
</html>
*/
?>
