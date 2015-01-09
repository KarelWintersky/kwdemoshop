<?php
session_start();
require_once "lib_core.php";

$link = ConnectDB();
unset($item);
$magic_number = $_POST["rnd982g"];
$qa = array(
    'time_create' => time(),
    'user_name' => conv($_POST["FAQ_user_name"]),
    'user_id' => $_SESSION['userinfo']["user_id"],
    'question' => mysql_real_escape_string(conv($_POST['FAQ_Question'])),
    'answer' => mysql_real_escape_string(conv($_POST['FAQ_Answer'])),
    'magic' => $_POST["rnd982g"]
);
$qs = MakeInsert($qa,'faq');

//проверка такой записи УЖЕ

$is_dup_r = mysql_query("SELECT magic FROM faq WHERE magic=$magic_number") or Die("Невозможно проверить дубликат!");
$is_dup = mysql_num_rows($is_dup_r);
if (!$is_dup)
{
    $res = mysql_query($qs,$link) or Die("Невозможно сохранить вопрос в БД!".$q);
    $new_id = mysql_insert_id() or Die("Невозможно получить id последней записи из БД! [$q]");
    mysql_close($link);
}
printf('Вопрос добавлен!<br><input type="button" name="return" value="Вернуться" onClick="RefreshAndClose(this)">');
die;
?>



