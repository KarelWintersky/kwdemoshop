<?php
require_once "lib_core.php";
//  global $CONFIG;
//
$id = $_GET["id"];
$link = ConnectDB();
$q = "DELETE FROM ".$CONFIG['table_articles']." WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос на удаление товара! [$q]");
CloseDB($link);
printf('Статья удалена из базы!');
?>
