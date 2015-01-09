<?php
require_once "../backlog.lib.php";
require_once "../logging.lib.php";
$link = ConnectDB();
DebugTo('backlog.order.show');

$oid = $_GET['id']; // идентификатор (№) заказа по бэклогу

/* Кроме того, мы обновляем поле backlog.time_inwork
но только если time_inwork is null */
$time = time();
$query = "update $CONFIG[table_backlog] set time_inwork=now(),time_inwork_s=unix_timestamp(now()) where time_inwork is null and id=$oid ";
mysql_query($query);
/* повысить статус заказа если он равен 1 (2 - находится в обработке) */
$query = "update $CONFIG[table_backlog] set status=2 where status=1 and id=$oid";
mysql_query($query);
// Debug($query);
$query = "SELECT *,DATE_FORMAT(time_add,'$CONFIG[mysql_format_date_1]') as time_add_d, ";
$query.= " DATE_FORMAT(time_inwork,'$CONFIG[mysql_format_date_1]') as time_inwork_d ";
$query.= " FROM backlog ";
$query.= " WHERE id=$oid ";

$request = mysql_query($query) or Die("Ошибка получения информации о заказе: ".$query);
$order = mysql_fetch_assoc($request);

$uid = $order['u_id']; // идентификатор заказавшего пользователя (0 если гость)
$pid = $order['r_id']; // идентификатор продукта по базе
$status = $order['status'];
$disabled_delivery = ($status>2) ? " disabled" : "";
$disabled_close = ($status>3) ? " disabled" : "";
CloseDB($link);
?>


<table border="1" class="orderwork">
    <tr class="ow_topheader">
        <td>
            <input type="button" class="b_ow_productinfo" id="<?php echo $pid ?>" value="О товаре...">
        </td>

        <td width="20%">
            <input type="button" class="b_ow_clientmail" id="<?php echo $uid ?>" value="Письмо клиенту">
        </td>

        <td width="20%">
            <input type="button" class="b_ow_cancelorder" id="<?php echo $oid ?>" value="Отменить заказ"<?php echo $disabled; ?>>
        </td>

        <td width="20%">
            <input type="button" class="b_ow_deliveryconfirm" id="<?php echo $oid ?>" value="Доставлено!"<?php echo $disabled_delivery; ?>>
        </td>

        <td width="20%">
            <input type="button" class="b_ow_finite" id="<?php echo $oid ?>" value="Закрыть заказ!"<?php echo $disabled_close; ?>>
        </td>
    </tr>
    <tr>
        <td colspan="5" class="superheader">Информация о заказе:</td>
    </tr>
    <tr>
        <th>№ заказа</th>
        <th>Производитель</th>
        <th>Модель</th>
        <th>Кол-во</th>
        <th>Сумма заказа</th>
    </tr>
    <tr>
        <td>№ <?php echo $order['r_id']; ?>/<?php echo $order['id']; ?></td>
        <td><?php echo $order['r_producer']; ?></td>
        <td><?php echo $order['r_title']; ?></td>
        <td><?php echo $order['r_num_r'].' + '.$order['r_num_l']; ?></td>
        <td><?php echo $order['cost']/100; ?></td>
    </tr>
    <tr>
        <td colspan="5" class="superheader">Линзы:</td>
    </tr>
    <tr>
        <th>Базовая<br> кривизна</th>
        <th>Оптическая<br>сила</th>
        <th>Цвет</th>
        <th>Цилиндр<br><span class="warning">(cyl)</span></th>
        <th>Опт.ось<br><span class="warning">(axis)</span></th>
    </tr>

    <tr>
        <td>
            <span class="red">П: </span><?php echo $order['r_basecurve_r'];?>
            <br>
            <span class="red">Л: </span><?php echo $order['r_basecurve_l'];?>
        </td>
        <td>
            <span class="red">П: </span><?php echo $order['r_optpower_r'];?>
            <br>
            <span class="red">Л: </span><?php echo $order['r_optpower_l'];?>
        </td>
        <td>
            <span class="red">П: </span><?php echo $order['r_color_r'];?>
            <br>
            <span class="red">Л: </span><?php echo $order['r_color_l'];?>
        </td>
        <td>
            <span class="red">П: </span><?php echo $order['r_cyl_r'];?>
            <br>
            <span class="red">Л: </span><?php echo $order['r_cyl_l'];?>
        </td>
        <td>
            <span class="red">П: </span><?php echo $order['r_axis_r'];?>
            <br>
            <span class="red">Л: </span><?php echo $order['r_axis_l'];?>
        </td>
    </tr>


    <tr>
        <td colspan="5" class="superheader">Информация о клиенте:</td>
    </tr>
    <tr>
        <th colspan="2" class="subheader">Ф.И.О.</th>
        <th class="subheader">E-Mail</th>
        <th>Телефон</th>
        <th>login</th>
    </tr>
    <tr>
        <td colspan="2"><?php echo $order['u_name']; ?></td>
        <td><a href="mailto:<?php echo $order['u_email']; ?>"><?php echo $order['u_email']; ?></a></td>
        <td><a href="skype:+<?php echo $order['u_phone']; ?>?call" onclick="return skypeCheck()">+<?php echo $order['u_phone']; ?></a></td>
        <td><?php echo $order['nickname']; ?></td>
    </tr>
    <tr>
        <th colspan="1">&nbsp;<br>Место покупки <br>или доставки:<br>&nbsp;</th>
        <td colspan="3" class="j"><?php echo $order['u_addr'];?></td>
        <td><input type="button" class="b_ow_changedelivery" id="<?php echo $oid ?>" value="Изменить"<?php /* echo $disabled; */ ?> disabled></td>
    </tr>
    <tr>
        <td colspan="5" class="superheader c">Работа с заказом</td>
    </tr>
    <tr>
        <th colspan="2">Заказ сделан: </th>
        <td colspan="3" class="j">
    <span id="mow_time_add">
    <?php
        // echo date("d/M/Y \n G:i",$order['time_add_s']);
        echo $order['time_add_d'];
        ?>
    </span>
        </td>
    </tr>
    <tr>
        <th colspan="2">Принят в обработку: </th>
        <td colspan="3" class="j">
    <span id="mow_time_inwork">
    <?php
        if ($order['time_inwork_s']) echo date("d M Y G:i",$order['time_inwork_s']);
        else echo 'Обработка заказа не проводилась';
        ?>
    </span>
        </td>
    </tr>
    <tr>
        <th colspan="2">Получен клиентом: </th>
        <td colspan="3" class="j">
    <span id="mow_time_delivery">
    <?php
        if ($order['time_delivery_s']) echo date("d M Y G:i",$order['time_delivery_s']);
        else echo 'Клиент еще не получил заказ';
        ?>
    </span>
        </td>
    </tr>
    <tr>
        <th colspan="2">Обработка завершена: </th>
        <td colspan="3" class="j">
    <span id="mow_time_finalize">
    <?php
        if ($order['time_finalize_s']) echo date("d M Y G:i",$order['time_finalize_s']);
        else echo 'Обработка заказа не завершена';
        ?>
    </span>
        </td>
    </tr>
    <!--
<tr>
    <th>Комментарии:</th>
    <td colspan="3"><textarea id="order_comment" cols="60" rows="4"><?php echo $order['comment'] ?></textarea>
    <span class="status_comment"><br></span>
    </td>
    <td>
    <input type="button" class="b_ow_commentupdate" id="<?php echo $oid ?>" value="Изменить">
    </td>
</tr>
-->

</table>