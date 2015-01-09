<?php
require_once "../backlog.lib.php";
require_once "../logging.lib.php";
$link = ConnectDB();

$id = $_GET['id'];

$result = mysql_fetch_assoc(mysql_query("select now() as time,DATE_FORMAT(now(),'$CONFIG[mysql_format_date_1]') as show_time"));
$time = $result['time'];

$query = "update backlog set status=3, time_delivery='$time',time_delivery_s=unix_timestamp('$time') where time_delivery is null and id=$id ";
mysql_query($query) or Die(mysql_error());
if (mysql_affected_rows())
{
    $data['date'] = $result['show_time'];
    $data['updated'] = 1;
} else {
    $data['updated'] = 0;
}

print(json_encode($data));
CloseDB($link);
?>