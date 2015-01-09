<?php
require_once "config/config.php";
require_once "SPAW_Wysiwyg.php";
// setlocale(LC_TIME, "ru_RU.CP1251");

function ConnectDB()
{
    global $CONFIG;
    $hostname = ($_SERVER['REMOTE_ADDR']==="127.0.0.1") ? $CONFIG['host_local'] : $CONFIG['host_remote'];
    $username = ($_SERVER['REMOTE_ADDR']==="127.0.0.1") ? $CONFIG['username_local'] : $CONFIG['username_remote'];
    $password = ($_SERVER['REMOTE_ADDR']==="127.0.0.1") ? $CONFIG['password_local'] : $CONFIG['password_remote'];
    $database = ($_SERVER['REMOTE_ADDR']==="127.0.0.1") ? $CONFIG['database_local'] : $CONFIG['database_remote'];
    $link=mysql_connect($hostname,$username,$password);
    mysql_select_db($database,$link) or die("Could not select db: " . mysql_error());
    mysql_query("SET NAMES utf8", $link);
    return $link;
}

function CloseDB($link)
{
    mysql_close($link) or Die("Не удается закрыть соединение с базой данных.");
}

function PrintTime($ts)
{
    global $CONFIG;
    $str = date($CONFIG['time_format'],$ts);
    return $str;
}

function PrintDate($ts)
{
    global $CONFIG;
//  $str = strftime($CONFIG['time_format_date'],$ts);
//  return $str;
    return strftime("%d %B %Y",$ts);
}


// Запрет кэширования страницы. Рекомедуется вызывать в самом начале любого скрипта
function NoCache()
{
    Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    Header("Cache-Control: no-cache, must-revalidate");
    Header("Pragma: no-cache");
    Header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
};

function PrintPrice($cost,$country,$mode='show')
{
    global $CURRENCY;
    global $CONFIG;
    $def_currency = $CONFIG['default_currency'];
    $prefix = IsSet($country) ? $CURRENCY[$country]['prefix'] : $CURRENCY[$def_currency]['prefix'];
    $hi = IsSet($country) ? $CURRENCY[$country]['hi'] : $CURRENCY[$def_currency]['hi'];
    $lo = IsSet($country) ? $CURRENCY[$country]['lo'] : $CURRENCY[$def_currency]['lo'];
    $hi_price = floor($cost/100);
    $lo_price = ($cost%100);
    $infix = strtolower($country);
    if ('show'==$mode) {
        $str = '<span class="price_prefix"> '.$prefix.' <span class="price_hi">'.$hi_price.' '.$hi.' </span><span class="price_lo" style="display:none">'.$lo_price.' '.$lo.'</span></span>';
//      $str = $hi_price.' '.$hi;
    }
    else
    {
        $str = '<span class="price_prefix"> '.$prefix;
        $str .= '<input type="text" name="price_'.$infix.'_hi" size="7" maxlenght="7" class="price_hi" value="'.$hi_price.'"> '.$hi;
        $str .= '<input type="text" name="price_'.$infix.'_lo" size="7" maxlenght="7" class="price_lo" value="'.$lo_price.'"> '.$lo;
        // по убедительной просьбе заказчика копейки убраны... А жаль. Вот так и забывают про Георгия Победоносца.
        $str .= '</span>';
    };
    return $str;
}


function IsShowNow($data) // возвращает истину если статья в сейчас отображается.
{
    $ct = time();
    $st = $data["display_start"];
    $et = $data["display_end"];
    return (($st<=$ct)&&($et>=$ct));
}

function NewMagicNumber()
{
    mt_srand(time());
    return time()+rand(0,1000000000);
}

function InsertSWFObject($url,$height,$width)
{
    echo '
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="'.$width.'" height="'.$height.'">
<param name="movie" value="'.$url.'" />
<param name="quality" value="high" />
<param name="wmode" value="transparent">
<embed src="'.$url.'" wmode="transparent"
quality="high"
pluginspage="http://www.macromedia.com/go/getflashplayer"
type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'">
</embed>
</object>';
}


function LoadUserInfo($id)
{
    ConnectDB();
    $q = "SELECT * FROM userlist WHERE id='$id'";
    $res = mysql_query($q) or die("Не удается выполнить запрос к базе пользователей".$q);
    $userinfo = mysql_fetch_assoc($res);
    return $userinfo;
}


//## перекодировка unicode UTF-8 -> win1251
function utf8_win ($s){
    $out="";
    $c1="";
    $byte2=false;
    for ($c=0;$c<strlen($s);$c++){
        $i=ord($s[$c]);
        if ($i<=127) $out.=$s[$c];
        if ($byte2){
            $new_c2=($c1&3)*64+($i&63);
            $new_c1=($c1>>2)&5;
            $new_i=$new_c1*256+$new_c2;
            if ($new_i==1025){
                $out_i=168;
            }else{
                if ($new_i==1105){
                    $out_i=184;
                }else {
                    $out_i=$new_i-848;
                }
            }
            $out.=chr($out_i);
            $byte2=false;
        }
        if (($i>>5)==6) {
            $c1=$i;
            $byte2=true;
        }
    }
    return $out;
}

//# Функция обнаружения того, что строка $str закодирвана UTF-8 (бинарно)
//# Возвращает true если UTF-8 или false если ASCII

function detect_utf($Str) {
    for ($i=0; $i<strlen($Str); $i++) {
        if (ord($Str[$i]) < 0x80) $n=0; # 0bbbbbbb
        elseif ((ord($Str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
        elseif ((ord($Str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
        elseif ((ord($Str[$i]) & 0xF0) == 0xF0) $n=3; # 1111bbbb
        else return false; # Does not match any model
        for ($j=0; $j<$n; $j++) { # n octets that match 10bbbbbb follow ?
            if ((++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80)) return false;
        }
    }
    return true;
}

//# Возвращает запрошенный справочник в формате ассоциативного массива,
//# [key=>value], где key - id элемента справочника, value - элемент справочника.
//# Сделано для удобства перебора массива связкой foreach $smth as ($i=>$v)
//# !!! внимание, проверка отсутствия базы не ведется, применять осторожно

function LoadReference($name)
{
    $link = ConnectDB();
    $q = "SELECT id, data FROM $name";
    $res = mysql_query($q) or Die("Невозможно произвести выборку данных из справочника: ".$name);
    $ref_size = mysql_num_rows($res);
    $ret=array();
    while ($data =  mysql_fetch_assoc($res)) $ret[$data['id']] = $data['data'];
    return $ret;
}

function GetRefData($refname, $id)
{
    $link = ConnectDB();
    $q = "SELECT data FROM $refname WHERE id=$id";
    $res = mysql_query($q) or Die("Невозможно получить данные из справочника $q , id = $id");
    $ret = mysql_fetch_assoc($res);
    return $ret['data'];
}

function MakeInsert($arr,$table,$where="")
{
    $str = "INSERT INTO $table ";

    $keys = "(";
    $vals = "(";
    foreach ($arr as $key => $val) {
        $keys .= $key . ",";
        $vals .= "'".$val."',";
    }
    $str .= trim($keys,",") . ") VALUES " . trim($vals,",") . ") ".$where;
    return $str;
}

function MakeUpdate($arr,$table,$where="")
{
    $str = "UPDATE $table SET ";
    foreach ($arr as $key=>$val)
    {
        $str.= $key."='".$val."', ";
    };
    $str = substr($str,0,(strlen($str)-2)); // обрезаем последнюю ","
    $str.= " ".$where;
    return $str;
}

function conv($str)  // converts from UTF-8 to Win-1251 locale. DEPRECATED, returns unchanged args
{
    // $s = iconv("utf-8", "windows-1251", $str);
    return $str;
}

function ReloadUserinfo($id)
{
    ConnectDB();
    $q = "SELECT * FROM userlist WHERE id='$id'";
    $res = mysql_query($q) or die("Не удается выполнить запрос к базе пользователей".$q);
    $userinfo = mysql_fetch_assoc($res);
    unset($_SESSION['userinfo']);
    $_SESSION['userinfo'] = $userinfo;
    return $userinfo;
}

function GetHumanFriendlyCounter($num,$str1,$str2,$str3)
{
    if ($num==0) $ret = $str3;
    if ($num==1) $ret = $str1;
    if ($num<21)
    {
        if ($num == 1) $ret = $str1;
        if (($num>1)&&($num<5)) $ret = $str2;
        if (($num>4)&&($num<21)) $ret = $str3;
    }
    else
    {
        $residue = ($num%10);
        if ($residue == 1) $ret = $str1;
        if (($residue>1)&&($residue<5)) $ret = $str2;
        if (($residue>4)&&($residue<=9)) $ret = $str3;
        if ($residue == 0) $ret = $str3;
    }
    return $ret;
}

function LogReferrer($fx='')
{
    if (!is_dir(".logs")) mkdir(".logs");
    if ($fx=="") $fn = '.logs/referrers.txt';
    else $fn = $fx;
    $f = fopen($fn,"a+") or Die($fn);
    $req_arr = array (
        'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
        'REQUEST_URI' => $_SERVER['REQUEST_URI'],
        'QUERY_STRING' => $_SERVER['QUERY_STRING'],
//    'argv' => $_SERVER['argv'],
        'SERVER_NAME' => $_SERVER['SERVER_NAME'],
        'REQUEST_TIME' => $_SERVER['REQUEST_TIME'],
//    'HTTP_ACCEPT_CHARSET' => $_SERVER['HTTP_ACCEPT_CHARSET'],
        'HTTP_REFERER' => $_SERVER['HTTP_REFERER'],
        'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT']
    );
    $req = serialize($req_arr);
//  $req = implode(';',$_SERVER);
    fputs($f,$req."\n");
    fclose($f);
}

function LogSessionInfoToFile()
{
    if (!is_dir(".logs")) mkdir(".logs");
    $fn = '.logs/log_session.txt';
    $f = fopen($fn,"a+") or Die($fn);
    $req = serialize($_SESSION);
    fputs($f,$req."\n");
    fclose($f);
}

/* v 1.1 functions */
/* проверяет существование таблицы в текущей ОТКРЫТОЙ(!) базе данных */
function is_table_exists($table)
{
    $flag = (mysql_query("SELECT 1 FROM $table WHERE 0"))? true : false;
    return $flag;
    /* Кстати, список таблиц в БД отдаст запрос: SHOW TABLES [FROM имя-базы] */
}

function DebugInfo($x)
{
    echo '<pre>';
    print_r($x);
    echo '</pre>';
}

function println($str)
{
    printf($str."\n");
}

function json_fix_cyr($var)
{
    if (is_array($var)) {
        $new = array();
        foreach ($var as $k => $v) {
            $new[json_fix_cyr($k)] = json_fix_cyr($v);
        }
        $var = $new;
    } elseif (is_object($var)) {
        $vars = get_object_vars($var);
        foreach ($vars as $m => $v) {
            $var->$m = json_fix_cyr($v);
        }
    } elseif (is_string($var)) {
        $var = iconv('cp1251', 'utf-8', $var);
    }
    return $var;
}

function json_safe_encode($var)
{
    return json_encode(json_fix_cyr($var));
}

/* вывод комментария */
function test_p($str) {
    printf('<!-- test data is: %s -->',$str);
}

function ReturnDate($ts)
{
    return strftime("%d %B %Y",$ts);
}

function ReturnTime($ts)
{
    global $CONFIG;
    return date($CONFIG['format_time'],$ts);
}

/* Функция обновляет в указанной таблице указанные поля текущим временем. База должна быть открыта!
   Условие задается БЕЗ WHERE                                                                                                  */
function UpdateNow($table, $timestamp_field, $int_field, $where)
{
    $time = time();
    mysql_query("update $table set $timestamp_field=now(), $int_field = '$time' where $where ");
}

?>