<?php
/* общая информация из бэклога */
require_once "../backlog.lib.php";
require_once "../logging.lib.php";
$link = ConnectDB();
DebugTo('get.backlog.info');

$data['size'] = GetBacklogSize();
$now = time();
$query = "select max($now-time_add_s) as maxtime from backlog where status<4";
Debug($query);

$request = mysql_query($query) or Die($query);
$result = mysql_fetch_assoc($request);

setlocale(LC_TIME, "ru_RU.CP1251");
$data['date'] = date("l, d/M/Y");
$data['time'] = date("G:i");
$data['maxtime'] = round($result['maxtime']/60); // в минутах
$data['maxtime_ms'] = $result['maxtime'];


$jdata = json_encode($data);
print($jdata);

CloseDB($link);
?>