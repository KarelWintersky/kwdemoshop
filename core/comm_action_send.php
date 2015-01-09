<?php
  require_once "lib_core.php";

  $from = $_POST["comm_from"];
  $back_email = $_POST["comm_email"];
  $subject = IsSet($_POST["comm_subject"]) ? mysql_escape_string(conv($_POST['comm_subject'])) : "test";
  $msg = IsSet($_POST["comm_msg"]) ? mysql_escape_string(conv($_POST['comm_msg'])) : "test";
  $msg.="<br>\n----------------------------------------------------------------------<br>\n";
  $msg.="E-Mail отправителя: ".$_POST["comm_email"];

  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers.= 'Content-type: text/html; charset=windows-1251' . "\r\n";
  $headers.= 'From: Newglance delivery system <nocallback@newglance.ru>' . "\r\n" .
   'Reply-To: nocallback@newglance.ru' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();

  foreach ($CONFIG['manager_email'] as $k=>$to)
  {
    mail($to, $subject, $message, $headers);
  }

  mail($CONFIG['control_email'], $subject, $message, $headers);

  echo '<span class="message">Сообщение отправлено менеджеру</span>';
//  print_r($msg);
?>



