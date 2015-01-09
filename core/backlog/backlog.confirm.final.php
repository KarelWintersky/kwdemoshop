<?php
require_once "../backlog.lib.php";
require_once "../logging.lib.php";
$link = ConnectDB();

$id = $_GET['id'];

$result = mysql_fetch_assoc(mysql_query("select now() as time,DATE_FORMAT(now(),'$CONFIG[mysql_format_date_1]') as show_time"));
$time = $result['time'];

$query = "update $CONFIG[table_backlog] set status=4,time_finalize='$time',time_finalize_s=unix_timestamp('$time') where id=$id ";
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