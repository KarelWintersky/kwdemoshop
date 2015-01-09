<?php
require_once "../lib_core.php";
$id = $_GET["id"];
$name = $_GET["name"];
$link = ConnectDB();
$q = "DELETE FROM $name WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос на удаление элемента! [$q]");
CloseDB($link);
printf('<span style="color:red">Эта строка удалена!</span>');
?>

