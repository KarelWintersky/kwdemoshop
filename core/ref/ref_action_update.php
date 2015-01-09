<?php
// ref - куда
// value - что
$ref_name = IsSet($_POST["name"]) ? ($_POST["name"]) : "test";
$id = $_POST["id"];
$reload = IsSet($_POST["reload"]) ? ($_POST["reload"]) : "this";

session_start();
require_once "../lib_core.php";
$link = ConnectDB();
unset($item);

$value = mysql_real_escape_string(($_POST['value']));

$magic = $_POST["rnd982g"];
$item["time_create"] = time();

if ($value!="")
{
    $q = "UPDATE $ref_name SET data='".$value."' WHERE id=$id";

    $res = mysql_query($q,$link) or Die("Невозможно изменить поле справочника в БД!".$q);
}

mysql_close($link);

if ($reload=="this")
    printf('Данные добавлены!<input type="button" name="return" value="Обновить" onClick="window.location.href=window.location.href">');
if ($reload=="parent")
    printf('Данные добавлены!<br><input type="button" name="return" value="Обновить и вернуться" onClick="RefreshAndClose(this)">');


die;
?>




