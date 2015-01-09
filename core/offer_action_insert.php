<?php
require_once "lib_core.php";
unset($goods);

$date_start = explode('/',$_POST["DisplayStart"]);  // d/M/Y   0 1 2
$date_end = explode('/',$_POST["DisplayEnd"]);

$qa = array (
    'title' => mysql_real_escape_string($_POST["OfferTitle"]),
    'text' => mysql_real_escape_string($_POST["OfferText"]),
    'shortinfo' => mysql_real_escape_string($_POST["OfferShort"]),
    'rating' => IsSet($_POST["Rating"]) ? $_POST["Rating"] : 0,
    'display_for' => $_POST["DisplayFor"],
    // обработаем даты
    'display_start' => mktime(0, 0, 0, $date_start[1],$date_start[0], $date_start[2]),
    'display_end' => mktime(0, 0, 0, $date_end[1],$date_end[0], $date_end[2]),
    // обработаем служебные поля
    'time_create' => 0+time(),
    'time_modify' => 0+time(),
    'user_create' => $_SESSION['userinfo']['id'],
    'user_modify' => $_SESSION['userinfo']['id'],
);
$qs = MakeInsert($qa,'offerslist');
// начинаем вставку данных

$link = ConnectDB();

$res = mysql_query($qs,$link) or Die("Невозможно добавить товар в БД!<br>[$q]");
$new_id = mysql_insert_id() or Die("Невозможно получить id последней записи из БД! <br>[$q]");
$offer['msg'] = "Новый рекламная акция в базу добавлена.";
print_r($offer['msg']);
// можно напечатать, что мы успешно обработали результат
?>
<br>
<input type="button" name="Return_to_offers" value="Вернуться к списку рекламных акций" onClick="document.location.href='offers.php';return false;">


