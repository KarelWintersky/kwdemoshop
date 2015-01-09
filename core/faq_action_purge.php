<?php
require_once "lib_core.php";
$id = $_GET["id"];
$link = ConnectDB();
$q = "DELETE FROM faq WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос на удаление элемента! [$q]");
CloseDB($link);
printf('Вопрос удален из базы!');
?>
