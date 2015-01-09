<?php
session_start();
require_once "core/lib_core.php";

$message = $_POST;
foreach ($message as $k=>$v)
    if ($v==="") $message[$k]="n/a";

$to = $CONFIG['resume_email'];

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers.="Content-type: text/plain; charset=\"windows-1251\"\r\n";
$headers.="Reply-To: nocallback@newglance.ru\r\n".'X-Mailer: PHP/'.phpversion();
$headers.="From: Newglance delivery system <nocallback@newglance.ru>\r\n";
$subject = 'Соискатель выслал свое резюме. ';

$message="
Вакансия:       $message[vacancy]
Фамилия:        $message[surname]
Имя:            $message[name]
Отчество:       $message[patro]
Телефон:        $message[phone]
E-Mail:         $message[email]
Дата рождения:  $message[birthdate]
Гражданство:    $message[citizenship]
Фактическое место проживания:
$message[livehere]
Образование:    $message[school]
Специальность:  $message[speciality]
Дата окончания: $message[enddate]
Последнее место работы:
$message[last_work]
Опыт работы в оптике:
$message[exp]
Дополнительная информация:
$message[addinfo]
Пожелания и вопросы:
$message[wishes]
";

foreach ($CONFIG['manager_email'] as $k=>$v)
    mail($v, $subject, $message, $headers);

mail($CONFIG['control_email'], $subject, $message, $headers);

?>
Ваше резюме отправлено менеджеру. Мы свяжемся с вами в ближайшее время.
<br>
<input type="button" name="Return" value="Вернуться на сайт" onClick="document.location.href='index.php';return false;">
