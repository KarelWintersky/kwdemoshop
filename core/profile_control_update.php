<?php
require_once "lib_core.php";

$newdata = array (
    'surname' => conv($_POST["surname"]),
    'name' => conv($_POST["name"]),
    'patro' => conv($_POST["patro"]),
    'phone' => conv($_POST["phone"]),
    'email' => conv($_POST["email"]),
    'delivery_addr' => mysql_escape_string(conv($_POST['delivery_addr'])),
    'is_subscriber' => IsSet($_POST["is_subscriber"]) ? 1 : 0
);
$username = conv($_POST['username']);
$password = conv($_POST['password']);
$id = IsSet($_POST['id']) ? $_POST['id'] : 0;
if ($id) {
    ConnectDB();
    $q = "SELECT userpassword FROM $CONFIG[table_users] WHERE id=$id";
    $rr = mysql_query($q);
    $data = mysql_fetch_assoc($rr);
    $currpass = $data['userpassword'];
    if (md5($password)===$currpass) {
        // введенный пароль = текущему
        // а теперь 2 варианта - мы меняем пароль и не меняем.
        // если $_POST['newpassword'] существует - мы его добавим к $newdata
        // а потом сгенерим строку запроса для вставки.
        if ($_POST['newpassword']) $newdata['userpassword'] = md5(conv($_POST['newpassword']));
        $link = ConnectDB();
        $q = MakeUpdate($newdata,$CONFIG[table_users],"WHERE (id=$id)");
        $res = mysql_query($q,$link) or Die("Невозможно обновить запись о пользователе в БД! [$q]");
        $message = '<span class="pe_correct">Пароль верен! Данные пользователя изменены!</span>';
    } else {
        // введенный пароль НЕ ВЕРЕН
        $message = '<span class="pe_error">Пароль неверен! Изменить данные пользователя нельзя!</span>';
    }
}
else {
    $message = '<span class="pe_error" >Изменить пользовательские данные гостя нельзя!</span>';
}
$message.= '<input class="pe_button" type="button" value="Обновить" onClick="document.location.href=document.location.href">';
echo $message;
?>
