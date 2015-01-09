<?php
require_once "lib_core.php";

$CONFIG['table_backlog'] = 'backlog';
// define config variables
$CONFIG['php_format_time']     = "H:i:s";
$CONFIG['php_format_date']     = "d/M/Y";
$CONFIG['mysql_format_date_1'] = '%e %b %Y %H:%i';
$CONFIG['mysql_format_date_2'] = '%e.%m.%Y %H:%i';


function GetBacklogSize()
{
    global $CONFIG;
    $request = "SELECT COUNT(id) FROM $CONFIG[table_backlog] where status<4";
    $result = mysql_query($request) or Die("Невозможно получить количество новых заказов в журнале: ".$request);

    $count_array = mysql_fetch_array($result);
    return $count_array[0];
}



?>