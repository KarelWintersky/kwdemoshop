<?php
require_once $_SERVER['DOCUMENT_ROOT']."/core/lib_core.php";
session_start();

// выслать пароль на мыло
$register_name = $_POST['username'];
$link = ConnectDB();
$q = "SELECT id,name,patro,surname,email FROM $CONFIG[table_users] WHERE username='$register_name'";
$r = mysql_query($q);
$user_exists = mysql_num_rows($r) or Die("Невозможно извлечь информацию из БД".$q);
if ($user_exists)
{
    // пользователь с таким логином существует
    $userinfo = mysql_fetch_assoc($r);
    // проверяем целостность емейла
    if ($userinfo['email']!="") {
        // генерируем новый пароль
        $new_password = '12345678';

        // E-Mail указан, можно отсылать пароль
        $to = $userinfo['email'];
        $subject = "Новый временный пароль для пользователя: $register_name";
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers.="Content-type: text/plain; charset=\"windows-1251\"\r\n";
        $headers.="From: Newglance delivery system <nocallback@newglance.ru>\r\n";
        $headers.="Subject: $subject";
        $headers.="Content-type: text/plain; charset=\"windows-1251\"";
        $headers.="Reply-To: nocallback@newglance.ru\r\n".
            'X-Mailer: PHP/'.phpversion();
        // составление текста сообщения
        $msg = '
  Здравствуйте!
  Вы запросили напоминание пароля на сайте http://www.newglance.org
  Из соображений безопасности мы храним Ваши коды доступа в зашифрованном виде и
не можем выслать вам старый пароль.
  Но мы установили для вашего аккаунта '.$register_name.' новый временный пароль
чтобы Вы могли войти на сайт и через панель управления (замочек) изменить его на
более удобный Вам.

  Ваш временный пароль: '.$new_password.'

  С уважением, автоматическая система восстановления паролей.
        ';
        $recover_req = array (
            'to' => $to,
            'subj' => $subj,
            'message' => $msg,
            'headers' => $headers
        );
        // шлем письмо
        $is_sent = mail($to, $subject, $msg, $headers);

        mail($CONFIG['control_email'], 'запрос восстановления пароля', "пользователь $to запросил восстановление пароля", $headers);

        $send_req['is_sent'] = $is_sent;
        // логгируем операцию
        $f = fopen(".logs/recover_accounts.txt","a+");
        fputs($f,serialize($send_req)."\n");
        fclose($f);
        // да, его же еще надо обновить на сайте!!!
        $md5_pass = md5($new_password);
        $q = "UPDATE $CONFIG[table_users] SET userpassword='$md5_pass' WHERE username='$register_name'";
        mysql_query($q) or Die("Невозможно установить временный пароль! ".mysql_error());
        // сообщение о результатах работы
        $message = "Проверьте пожалуйста свой почтовый ящик $userinfo[email] ";
    }
    else
    {
        $message = 'К сожалению восстановление невозможно. :( При регистрации вы не указали E-Mail!';
    }
} else
{
    // хренушки, пользователь не существует
    $message = 'Мы не нашли пользователя с регистрационным идентификатором '.$register_name.' в базе данных. Может быть вы хотите <a href="?action=register">зарегистрироваться</a>?';
};
CloseDB($link);
echo $message;
?><br><br>
<input type="button" name="Return" value="Вернутся на сайт" onClick="document.location.href='../index.php'" />



