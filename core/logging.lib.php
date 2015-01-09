<?php
/*
    Модуль: LOGGER
    Функции сбора и обработки статистических ланных для сайтов на движке ztCMS
*/

$SID = session_id();
// if(empty($SID)) session_start();

require_once 'lib_core.php';

$CONFIG['table_loguserinfo'] = 'log_browserinfo';
$CONFIG['table_logsurfing'] = 'log_surfing';
$CONFIG['table_debuglog'] = 'log_debug';
$CONFIG['table_logsession'] = 'log_session';

/* общие функции логгирования */
/* вызывается только при подключенной БД  */
function LogSessionInfo()
{
    global $CONFIG;
    $log = array(
        'logtime' => strftime('%Y-%m-%d %H:%M:%S', time()),
        'data' => serialize($_SESSION)
    );
    $str = MakeInsert($log,$CONFIG['table_logsession']);
    mysql_query($str) or Die("Ошибка в запросе логгирования сессии: ".$str);
}

/* определяет контекст логгирования */
function DebugTo($name="common")
{
    $_SESSION['debug_subject'] = $name;
}

/* заносит информацию в базу */
function Debug($message,$file=__FILE__,$line=__LINE__)
{
    global $CONFIG;
    // $link = ConnectDB();
    $log = array(
        'logtime' => strftime('%Y-%m-%d %H:%M:%S', time()),
        'subject' => $_SESSION['debug_subject'],
        'message' => mysql_real_escape_string($message)
    );
    $str = MakeInsert($log,$CONFIG['table_debuglog']);
    mysql_query($str) or Die("Ошибка при сохранении отладочной информации: ".$str);
}

/* проверяет существование таблицы в БД и при необходимости создает её */
function LoggingCheckIntegrity()
{
    global $CONFIG;
    $link = ConnectDB();
    // таблица информации о пользователе
    if (!is_table_exists($CONFIG['table_loguserinfo']))
    {
        $table_struct = '
  CREATE TABLE `'.$CONFIG['table_loguserinfo'].'` (
  `id` int(11) NOT NULL auto_increment,
  `visittime` int(11) default NULL,
  `screen_height` int(11) default NULL,
  `screen_width` int(11) default NULL,
  `color_depth` int(11) default NULL,
  `cookies_enabled` int(11) default NULL,
  `browser_id` varchar(40) default NULL,
  `browser_version` varchar(20) default NULL,
  `browser_OS` varchar(40) default NULL,
  `oscpu` varchar(20) default NULL,
  `ip` varchar(16) default NULL,
  `referer` varchar(120) default NULL,
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=cp1251;';
        $result = mysql_query($table_struct,$link) or Die("Невозможно создать таблицу лога: [$table_struct]");
    } else
    {
        $result = true;
    };

    // таблица сёрфинга
    if (!is_table_exists($CONFIG['table_logsurfing']))
    {
        $table_struct = 'CREATE TABLE `'.$CONFIG['table_logsurfing'].'` (
  `id` int(11) NOT NULL auto_increment,
  `visittime` int(11) default NULL,
  `remote_addr` char(16) default NULL,
  `request_uri` varchar(80) default NULL,
  `query_string` varchar(40) default NULL,
  `http_referer` varchar(80) default NULL,
  `pagecounter` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
';
        $result = mysql_query($table_struct,$link) or Die("Невозможно создать таблицу лога: [$table_struct]");
    }
    // таблица системных логов
    if (!is_table_exists($CONFIG['table_debuglog']))
    {
        $table_struct = '
CREATE TABLE `'.$CONFIG['table_debuglog'].'` (
  `id` int(11) NOT NULL auto_increment,
  `logtime` int(11) default NULL,
  `message` varchar(1024) default NULL,
  `subject` varchar(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

';
        $result = mysql_query($table_struct,$link) or Die("Невозможно создать таблицу лога: [$table_struct]");
    }
    // таблица логов сессии
    if (!is_table_exists($CONFIG['table_logsession']))
    {
        // создать таблицу сёрфинга
        $table_struct = '
    CREATE TABLE `'.$CONFIG['table_logsession'].'` (
  `id` int(11) NOT NULL auto_increment,
  `logtime` int(11) default NULL,
  `data` varchar(2048) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
    ';
        $result = mysql_query($table_struct,$link) or Die("Невозможно создать таблицу лога: [$table_struct]");
    }

//        $_SESSION['pagecounter'] = 0;

    CloseDB($link);
    return $result;
}

/* выполняет сохранение пользовательских данных (в основном о браузере) в соответствующей таблице БД */
/* указание параметра, отличного от 'yes' означает, что библиотеку jQuery необходимо подключить */
function LogUserInfo($jq='yes')
{
    $str = '
    <!-- сбор минимальных данных о браузере и ОС посетителя -->
    <script type="text/javascript" src="core/logging/BrowserDetect.js"></script>';
    if ($jq!='yes') $str .= '
    <script type="text/javascript" src="core/jquery/jquery.min.js"></script>';
    $str.='
  <script type="text/javascript">
  $.get("core/logging/log.userinfo.php",
    {
      screen_height: screen.height,
      screen_width: screen.width,
      color_depth: screen.colorDepth,
      cookies_enabled: (navigator.cookieEnabled) ? 1 : 0,
      browser_id: BrowserDetect.browser,
      browser_version: BrowserDetect.version,
      browser_OS: BrowserDetect.OS
    });
';
    $str.= '</script>';
    printf($str);
    printf("\r\n");
}

function LogServerInfo()
{
    global $CONFIG;
    $log = array(
        'visittime' => time(),
        'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
        'REQUEST_URI' => $_SERVER['REQUEST_URI'],
        'QUERY_STRING' => $_SERVER['QUERY_STRING'],
        'HTTP_REFERER' => $_SERVER['HTTP_REFERER'],
        'pagecounter' => IsSet($_SESSION['pagecounter']) ? $_SESSION['pagecounter'] : 1
    );
    $link = ConnectDB();
    $str = MakeInsert($log,$CONFIG['table_logsurfing']);
    mysql_query($str,$link) or Die("Ошибка в запросе: ".$str);
    CloseDB($link);
}

/* onload */
// проверка целостности базы

LoggingCheckIntegrity();

// пожалуй сам факт подключения этой библиотеки есть повод сохранить информацию с сервера
// в таблицу log_surfing (информация о серфинге по страницам)
/*
if ($_SESSION['internal_call']!=1) LogServerInfo();
else $_SESSION['internal_call']=0;
*/
?>