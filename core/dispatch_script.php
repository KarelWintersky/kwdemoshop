<?php
session_start();
require_once "lib_core.php";
$display_list = array (
    0 => "Гости",
    1 => "Покупатели",
    2 => "Лучшие покупатели",
    3 => "VIP",
    4 => "Менеджеры",
    5 => "Администратор",
    9 => "Системный оператор"
);
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers.="Content-type: text/plain; charset=\"windows-1251\"\r\n";
$headers.="From: Newglance delivery system <nocallback@newglance.ru>\r\n";
$headers.="Subject: $subject";
$headers.="Content-type: text/plain; charset=\"windows-1251\"";
$headers.="Reply-To: nocallback@newglance.ru\r\n".
    'X-Mailer: PHP/'.phpversion();

$message = mysql_real_escape_string($_POST["Mail_Text"]);
$subject = mysql_real_escape_string($_POST["Mail_Subject"]);
$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($subject, "w","k")).'?=';

$link = ConnectDB();

if (!IsSet($_POST["sendgroup"])) Die("Нельзя рассылать \"никому\"!!!" );

foreach ($_POST["sendgroup"] as $sg_i=>$group)
{
    // рассылаем сообщения группам
    $current_group = $display_list[$group];
    $q = "SELECT id,name,patro,surname,email FROM $CONFIG[table_users] WHERE (usergroup=$group)&&(is_subscriber=1)";
    $res = mysql_query($q) or Die("Выборка неуспешна, запрос: $q");
    $num_recp = mysql_num_rows($res);
    if ($num_recp)
    {
        echo "Рассылаем сообщение группе <b style=\"color:red\">$current_group</b>.<br>";
        while ($user=mysql_fetch_assoc($res))
        { // перебор всех полученных записей о пользователях
            $fio = $user['name']." ".$user['patro'];
            $to = $user['email'];
            $message = ereg_replace('%USERNAME%',$fio,$message);
            $is_sent = mail($to, $subject, $message, $headers);
            if ($is_sent) echo "Сообщение на адрес <b style=\"color:red\">$email</b> послано.<br>\n";
            else echo "Сообщение на адрес <b style=\"color:red\">$email</b> послать не удалось!<br>\n";
        }
    }
    else
    {
        echo "Невозможно разослать сообщение группе <b style=\"color:red\">$current_group</b>. Подписанных пользователей нет!<br>";
    };
    echo "<hr>";

}

CloseDB($link);
?>
<br>
<input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='dispatch.php'" />

