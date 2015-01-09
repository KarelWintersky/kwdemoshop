<?php 
/* 
Этот файл вызывается аякс-методом $.get() из функции LogUserInfo() 
для сохранения информации о браузере пользователя.
*/
session_start();
$_SESSION['internal_call'] = 1;
require_once "../logging.lib.php";

  if (count($_GET))
  {
      $log = $_GET;
      $log['visittime'] = strftime('%Y-%m-%d %H:%M:%S', time());
      $log['ip'] = $_SERVER['REMOTE_ADDR'];
      $log['referer'] = $_SERVER['HTTP_REFERER'];

      $link = ConnectDB();
      $str = MakeInsert($log,$CONFIG['table_loguserinfo']);
      mysql_query($str,$link) or Die("Ошибка в запросе: ".$str);

      CloseDB($link);
      printf('Информация о браузере пользователя собрана!');
  }
  else printf("Так вызывать нельзя!");

?>