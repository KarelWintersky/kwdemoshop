<?php
require_once "lib_core.php";
//
$id = $_GET["id"];
$link = ConnectDB();
$q = "DELETE FROM ".$CONFIG['table_offers']." WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос на удаление товара! [$q]");
CloseDB($link);
printf('Запись удалена из базы!<br>');
?>
