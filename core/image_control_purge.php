<?php
require_once "lib_gd.php";
//
$id=$_GET["id"];
$link = ConnectDB();
$result = mysql_query("DELETE FROM imagelist WHERE (id=$id)") or Die("Не удается выполнить запрос на удаление изображения!");
CloseDB($link);
printf('Изображение удалено из базы');
?>



