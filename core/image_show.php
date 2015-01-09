<?php
require_once "lib_gd.php";

// image_show.php?id=..
//
$id = $_GET['id'];
if ($id) {
    $link = ConnectDB() or Die("Не удается соединиться с базой данных!");
    $q = "SELECT image FROM ".$CONFIG['table_images']." WHERE (id=$id)";
    $result = mysql_query($q) or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
    $fetch = mysql_fetch_array($result) or Die("Не удается получить результат запроса ($q)");
    $raw_image = $fetch['image'];
    header("Content-type: image/jpeg");
    print($raw_image);
    flush();
    CloseDB($link);
} else
{
    header("Content-type: image/gif");
    print(base64_decode($noimg_240x180));
    flush();
};
?>