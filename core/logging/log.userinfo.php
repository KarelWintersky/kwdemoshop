<?php 
/* 
���� ���� ���������� ����-������� $.get() �� ������� LogUserInfo() 
��� ���������� ���������� � �������� ������������.
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
      mysql_query($str,$link) or Die("������ � �������: ".$str);

      CloseDB($link);
      printf('���������� � �������� ������������ �������!');
  }
  else printf("��� �������� ������!");

?>