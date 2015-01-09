<?php
require_once "lib_shop.php";
//
$id = $_GET["id"];
$link = ConnectDB();
$q = "DELETE FROM ".$CONFIG['table_market']." WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос на удаление товара! [$q]");
CloseDB($link);
printf('Товар удален из базы, для возврата к списку товаров нажмите:');
?>
<input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='goods.php'" />




