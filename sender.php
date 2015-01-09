<?php
/* ver 1.1
+ : добавление информации в таблицу BACKLOG
+ : обновление информации о количестве и сумме заказов у пользователя
*/
session_start();
require_once "core/lib_core.php";
require_once "core/logging.lib.php";
DebugTo('sender.php');
$userinfo = $_SESSION['userinfo'];

/* загрузим справочники */
ConnectDB();
//базовую кривизну
$name = "ref_basecurve";
$q = "SELECT id, data FROM $name";
$res = mysql_query($q) or Die("Невозможно произвести выборку данных из справочника: ".$name);
$ref_size = mysql_num_rows($res);
$ret=array();
while ($data =mysql_fetch_assoc($res)) $ret[$data['id']] = $data['data'];
$ref_basecurve = $ret;
//оптические силы
$name = "ref_opticpower";
$q = "SELECT id, data FROM $name";
$res = mysql_query($q) or Die("Невозможно произвести выборку данных из справочника: ".$name);
$ref_size = mysql_num_rows($res);
$ret=array();
while ($data =  mysql_fetch_assoc($res)) $ret[$data['id']] = $data['data'];
$ref_opticpower = $ret;
//производители
$name = "ref_producer";
$q = "SELECT id, data FROM $name";
$res = mysql_query($q) or Die("Невозможно произвести выборку данных из справочника: ".$name);
$ref_size = mysql_num_rows($res);
$ret=array();
while ($data =  mysql_fetch_assoc($res)) $ret[$data['id']] = $data['data'];
$ref_producer = $ret;
//цвета
$name = "ref_colors";
$q = "SELECT id, data FROM $name";
$res = mysql_query($q) or Die("Невозможно произвести выборку данных из справочника: ".$name);
$ref_size = mysql_num_rows($res);
$ret=array();
while ($data =  mysql_fetch_assoc($res)) $ret[$data['id']] = $data['data'];
$ref_colors = $ret;
//цилиндр для астигматики
$name = "ref_cylinder";
$q = "SELECT id, data FROM $name";
$res = mysql_query($q) or Die("Невозможно произвести выборку данных из справочника: ".$name);
$ref_size = mysql_num_rows($res);
$ret=array();
while ($data =  mysql_fetch_assoc($res)) $ret[$data['id']] = $data['data'];
$ref_cylinder = $ret;
// оптическая ось
$name = "ref_axis";
$q = "SELECT id, data FROM $name";
$res = mysql_query($q) or Die("Невозможно произвести выборку данных из справочника: ".$name);
$ref_size = mysql_num_rows($res);
$ret=array();
while ($data =  mysql_fetch_assoc($res)) $ret[$data['id']] = $data['data'];
$ref_axis = $ret;

// данные
$userinfo = $_SESSION['userinfo'];
$cart = $_SESSION['cart'];
$orders_num = $_SESSION['orders_num'];
$sum_price = $_SESSION['cart_sumprice'];

$fio = $_POST["fio"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$delivery_addr = $_POST["delivery_addr"];
$u_name = $_POST["u_name"];

$message = '';
$message.= "---------\r\n";
$message.='
Логин: '.$u_name.'
Телефон: '.$phone.'
E-Mail: '.$email.'
Ф.И.О. '.$fio.'
Дата и время заказа: '.PrintDate(time())."\r\n";
$message.='Всего заказов: '.$orders_num.'
';
$message.='
Адрес доставки: '.$delivery_addr;
$message.='---------
';

foreach ($cart as $id=>$record)
{
    $o_n = $id+1;
    $id = $record["id"];

    $q = "SELECT producer,title FROM market WHERE id=$id";
    $qres = mysql_query($q);
    $res = mysql_fetch_assoc($qres);
    $title = $res["title"];
    $producer = $res["producer"];
    $message.='
Заказ № '.$o_n;
    $message.='
Производитель: '.$ref_producer[$producer].'
Наименование: '.$title;
    $message.='
Радиусы кривизны: [ правый = '.$ref_basecurve[$record["bc_right"]]." ],  [ левый = ".$ref_basecurve[$record["bc_left"]].' ] ';
    $message.='
Оптическая сила:  [ правый = '.$ref_opticpower[$record["op_right"]]." ], [ левый = ".$ref_opticpower[$record["op_left"]].' ] ';
    $message.='
Цвета:            [ правый = '.$ref_colors[$record["color_right"]]." ],  [ левый = ".$ref_colors[$record["color_left"]].' ] ';
    $message.='
Количество:       [ правый = '.$record["num_right"]." штук(и) ],         [ левый = ".$record["num_left"]." штук(и) ]";
    $message.='
Стоимость этого заказа: '.floor($record['order_cost']/100)." рублей \r\n";
    $message.='---------
';
    UnSet($back_arr);
    $back_arr = array(
        'u_name'    => $fio,
        'u_phone'   => $phone,
        'u_login'   => IsSet($_SESSION['is_logged']) ? $_SESSION['username'] : '-',
        'u_addr'    => $delivery_addr,
        'u_ip'      => $_SERVER['REMOTE_ADDR'],
        'u_id'      => IsSet($_SESSION['is_logged']) ? $_SESSION['userinfo']['id'] : 0,
        'r_producer'=> $ref_producer[$producer],
        'r_title'   => $res["title"],
        // вставить проверки насчет установленности значений
        'r_basecurve_r' => $ref_basecurve[$record["bc_right"]],
        'r_basecurve_l' => $ref_basecurve[$record["bc_left"]],
        'r_optpower_r'  => $ref_opticpower[$record["op_right"]],
        'r_optpower_l'  => $ref_opticpower[$record["op_left"]],
        'r_color_r'     => $ref_colors[$record["color_right"]],
        'r_color_l'     => $ref_colors[$record["color_left"]],
        'r_cyl_r'       => $ref_cylinder[$record["cylinder_right"]],
        'r_cyl_l'       => $ref_cylinder[$record["cylinder_left"]],
        'r_axis_r'      => $ref_cylinder[$record["axis_right"]],
        'r_axis_l'      => $ref_cylinder[$record["axis_left"]],
        'r_id'          => $id,
        'r_num_r'       => $record["num_right"],
        'r_num_l'       => $record["num_left"],
        'r_cost'        => $record['order_cost'],
// updates backlog
        'time_inwork_s' => 0,
        'time_delivery_s' => 0,
        'time_finalize_s' => 0,
        // Статус
        'status' => 1,
        'delivery_type' => 0,
        'u_email' => $email,
// никнейм
        'nickname' => IsSet($_SESSION['is_logged']) ? $_SESSION['userinfo']['username'] : $_SESSION['user_nickname']
    );
    $request = MakeInsert($back_arr,'backlog');
    mysql_query("LOCK TABLES backlog WRITE");
    $result = mysql_query($request) or Die("Невозможно обновить таблицу BACKLOG: ".$request);
    $this_id = mysql_insert_id();
    $query = "update backlog set time_add=now(),time_add_s=unix_timestamp(now()) WHERE id=$this_id ";
    mysql_query($query) or Die("Ошибка: ".$query);
    mysql_query("UNLOCK TABLES");
}
$message.='Общая сумма:  '.floor($sum_price/100)." рублей.\r\n";
$subject = "Заказ от ".date("d/M/Y H:i:s");
/*
  Обновим записи в таблице пользователей:
*/
if (IsSet($_SESSION['is_logged'])) {
    $uid = $userinfo["id"];
    $query = "SELECT id,num_of_orders,sum_of_orders FROM userlist where id=$uid";
    $result = mysql_query($query) or Die("Невозможно получить данные о предыдущих покупках: ".$query);
    $data = mysql_fetch_assoc($result);
    $num_of_orders = $data['num_of_orders'];
    $sum_of_orders = $data['sum_of_orders'];


    $ul_arr = array (
        'num_of_orders' => $num_of_orders + $_SESSION['orders_num'],
        'sum_of_orders' => $sum_of_orders + $sum_price
    );
    $query = MakeUpdate($ul_arr,'userlist',"WHERE id=$uid");
    mysql_query($query) or Die("Невозможно обновить данные о покупках у пользователя: ".$query);
}


// пошлем нах
// сначала заказчику
$to = $email;

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers.="Content-type: text/plain; charset=\"windows-1251\"\r\n";
$headers.="From: Newglance delivery system <nocallback@newglance.ru>\r\n";
//  $headers.="Subject: $subject";
$headers.="Content-type: text/plain; charset=\"windows-1251\"";
$headers.="Reply-To: nocallback@newglance.ru\r\n".
    'X-Mailer: PHP/'.phpversion();

$send_req = array (
    'to' => $to,
    'subj' => $subj,
    'message' => $message,
    'headers' => $headers
);

$is_sent = mail($to, $subject, $message, $headers);
$send_req['is_sent'] = $is_sent;
//   $f = fopen(".logs/mails_user.txt","a+");
//  fputs($f,serialize($send_req)."\n");
//  fclose($f);
DebugTo('mail_user');
Debug(serialize($send_req));

// а теперь менеджерам
foreach ($CONFIG['manager_email'] as $k=>$to)
{
    $is_sent = mail($to, $subject, $message, $headers);
    $send_req['is_sent'] = $is_sent;
}

mail($CONFIG['control_email'], $subject, $message, $headers);
// лог
//  $f = fopen(".logs/mails_manager.txt","a+");
//  fputs($f,serialize($send_req)."\n");
//  fclose($f);


// а теперь очистим корзину
unset($_SESSION['cart']);
unset($_SESSION['cart_sumprice']);
unset($_SESSION['orders_num']);


// FIX_01: поправить общую логику вызовов...
?>
<head>
    <style>
        td {
            text-align: center;
        }
        td.l {
            text-align: left;
        }
    </style>
</head>
<body>
Если вы не увидели никаких сообщений кроме этого - то ваш заказ успешно отправлен менеджеру. <br>
На ваш e-mail (если вы его указали) отправлена информация о вашем заказе.
<div style="color:Red">Обращаем ваше внимание на то, что корзина очищена</div>
<br>
<input type="button" name="Return" value="Вернутся на сайт" onClick="document.location.href='index.php'" />
</body>


