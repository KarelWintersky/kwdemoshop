<?php
//offers

require_once "lib_core.php";
unset($offer);
$id = $_GET['id'];
// загрузим старую версию рекламной акции
$link = ConnectDB();
$q = "SELECT * FROM offerslist WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
$offer = mysql_fetch_assoc($result) or Die("Не удается получить результат запроса ($q)");

// начнем её обновлять согласно актуальной информации из $_POST
// название и описание

$offer['title'] = mysql_escape_string($_POST["OfferTitle"]);
$the_desc = $_POST["OfferText"];
$offer['text'] = mysql_escape_string($the_desc);
$offer['shortinfo'] = mysql_escape_string($_POST["OfferShort"]);
$offer['rating'] = IsSet($_POST["Rating"]) ? $_POST["Rating"] : 0;
$offer['display_for'] = $_POST["DisplayFor"];
// обработаем даты
$date_start = explode('/',$_POST["DisplayStart"]);  // d/M/Y   0 1 2
$offer['display_start'] = mktime(0, 0, 0, intval($date_start[1]),intval($date_start[0]),intval($date_start[2]));

$date_end = explode('/',$_POST["DisplayEnd"]);
$offer['display_end'] = mktime(0, 0, 0, intval($date_end[1]),intval($date_end[0]), intval($date_end[2]));
// обработаем служебные поля
$offer['time_modify'] = 0+time();
// обработаем данные о пользователе
$offer['user_modify'] = $USERINFO['current_user'];


// пошла вставка
$link = ConnectDB();
$q = "UPDATE offerslist";
$q = $q." SET  ";
foreach ($offer as $k=>$v)
{
    $q .= $k."='".$v."', ";
};
$q = substr($q,0,(strlen($q)-2)); // обрезаем последнюю ","
$q .= " WHERE (id=$id) ";
$res = mysql_query($q,$link) or Die("Невозможно обновить информацию о рекламой акции в БД! [$q]");
$offer['msg'] = "Рекламная акция № $id обновлена.";
print_r($offer['msg']);
?>
<!-- <input type="button" name="Return_to_market" value="Закрыть окно" onClick="window.close(self);return false;"> -->

<input type="button" name="Return_to_market" value="Вернуться к списку акций" onClick="document.location.href='offers.php'" /><br>


