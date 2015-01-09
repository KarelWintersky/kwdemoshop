<?php
require_once "lib_gd.php";
// image_action.php?action=preview&id=..
$id = $_GET['id'];
if ($id)
{
    $link = ConnectDB() or Die("Не удается соединиться с базой данных!");
    $result = mysql_query("SELECT preview FROM ".$CONFIG['table_images']." WHERE (id=$id)") or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
    $fetch = mysql_fetch_assoc($result) or Die("Не удается получить результат запроса ($q)");
    $raw_image = ($fetch['preview']);
    header("Content-type: image/gif");
    print($raw_image);
    flush();
    CloseDB($link);
} else
{
    header("Content-type: image/gif");
    print(base64_decode($noimg_120x90));
    flush();
}
?>