<?php
// ref - куда
// value - что
$ref_name = IsSet($_POST["name"]) ? $_POST["name"] : "test";

$reload = IsSet($_POST["reload"]) ? ($_POST["reload"]) : "this";

session_start();
require_once "../lib_core.php";
$link = ConnectDB();
unset($item);

$value = mysql_real_escape_string($_POST['value']);

$magic = $_POST["rnd982g"];
$item["time_create"] = time();

/* ADMIN CHECK : Вставить проверку на АДМИНА */
/* if (session_is_registered("user_id")) $item["user_id"] = $_SESSION['user_id'];
else $item["user_id"] = 0;
*/
if (IsSet($_POST["FAQ_user_name"])) $item["user_name"]=conv($_POST["FAQ_user_name"]);
else $item["user_name"] = $_SESSION['user_name'];



//проверка такой записи УЖЕ

$f = fopen("debug.txt","a+");
fputs($f,$q."\n");
fclose($f);
$q = "SELECT magic FROM $ref_name where magic='".$magic."'";
$is_dup_r = mysql_query($q);
$is_dup = mysql_num_rows($is_dup_r);
if ($value!="")
{
    $q = "INSERT INTO $ref_name (data,magic) ";
    $q = $q."VALUES (";
    $q = $q."'".$value."',";
    $q = $q."'".$magic."')";

    $res = mysql_query($q,$link) or Die("Невозможно сохранить вопрос в БД!".$q);
    $new_id = mysql_insert_id() or Die("Невозможно получить id последней записи из БД! [$q]");
    mysql_close($link);
}
if ($reload=="this")
    printf('<input type="button" name="return" value="Обновить" onClick="window.location.href=window.location.href"> -- Данные добавлены!');
if ($reload=="parent")
    printf('Данные добавлены!<br><input type="button" name="return" value="Обновить и вернуться" onClick="RefreshAndClose(this)">');

die;
?>








