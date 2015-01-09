<?php
$pause = array (
    'correct' => 3,
    'badpass' => 15,
    'nouser' => 15
);
$return_to = "index.php";
require_once "core/lib_core.php";
session_start();
$a_password = $_POST["password"];

// над проверить - есть такой пользователь или нет?
// FIX_01: Аяксом на стадии ввода

$link = ConnectDB();
$the_user = array (
    'username' => strtolower($_POST["username"]),
    'userpassword' => (md5($_POST["password"])),
    'register_date' => (time()),
    'usergroup' => 1,             // начальная группа пользователя по умолчанию
    'surname' => $_POST['surname'],
    'name' => $_POST['name'],
    'patro' => $_POST['patro'],
    'phone' => $_POST['phone'],
    'email' => $_POST['email'],
    'delivery_addr' => $_POST['delivery_addr'],
    'is_subscriber' => IsSet($_POST['is_subscribe']) ? 1 : 0,
);
$q_str = MakeInsert($the_user, $CONFIG['table_users'], "");

$res = mysql_query($q_str,$link) or Die("Невозможно сохранить пользователя в БД!".$q_str);
$new_id = mysql_insert_id() or Die("Невозможно получить id последней записи из БД! [$q]");
mysql_close($link);

$msg = "<!-- [$q_str] -->";
/* А теперь делаем автовход :) */

$_SESSION['is_logged']=1;
$the_user['fullname'] = $the_user['surname'].' '.$the_user['name'].' '.$the_user['patro'];
$_SESSION['userinfo'] = $the_user;
$is_admin = 0;
if ($the_user['usergroup']>999) $is_admin=1;
$_SESSION['is_admin'] = $is_admin;
$message1 = "Вы вошли на сайт как ".$_SESSION['userinfo']['username'];
$redirect_pause = $pause['correct'];
$message2 = 'Через <span id="wait"><span id="zeit">'.$redirect_pause.'</span></span> секунды вы будете перемещены на <a href="index.php">начальную страницу</a> сайта.';
echo "Пользователь № $new_id успешно создан. Теперь вы можете перейти на сайт.";

if (IsSet($_POST['return_to'])&&($_POST['return_to']==='cart')) $return_to = 'index.php?action=cart';
else $return_to = 'index.php';

?>
<br>
<input type="button" name="Return" value="Вернутся на сайт" onClick="document.location.href='<?php echo $return_to ?>'" />










