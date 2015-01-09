<?php
require_once "../backlog.lib.php";
$link = ConnectDB();

$size = GetBacklogSize();

$query = "SELECT * FROM backlog WHERE status<4";
$result = mysql_query($query) or Die("Невозможно получить список заказов из БД: ".$query);
$num = mysql_num_rows($result);
$nick = '';

$t = time();
?>

<table border="1" bordercolor="blue" width="100%" id="backlog_list" class="orderlist">
    <tr>
        <th colspan="10" class="r">Количество заказов в очереди: <?php echo $num; ?></th>
    </tr>
    <tr>
        <th>№</th>
        <th>id<br>клиента</th>
        <th>Дата</th>
        <th>Производитель</th>
        <th>Модель</th>
        <th>Кол-во<br><span class="warning">(П + Л)</span></th>
        <th>Сумма<br>заказа</th>
        <th colspan="3">Управление:</th>
    </tr>
    <?php while ($row = mysql_fetch_assoc($result)) {
    if ($nick!=$row['nickname']) {
        $nick = $row['nickname'];
        $n_name = $row['u_name'];
        $n_phone = $row['u_phone'];
        $n_email = $row['u_email'];
        ?>
        <tr>
            <td colspan="11" class="subheader">
                <span>Имя: </span><span class="info"><?php echo $n_name; ?></span>
                <span>Телефон: </span><span class="info"><?php echo $n_phone; ?></span>
                <span>E-Mail: </span><span class="info"><?php echo $n_email; ?></span>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php $login = ($row['login'] != '' ) ? $row['login'] : 'Гость'; echo $login; ?></td>
        <td><div><?php echo date("d/M/Y",$row['time_add_s']); ?></div><div><?php echo date("G:i:s",$row['time_add_s']); ?></div></td>
        <td><?php echo $row['r_producer']; ?></td>
        <td><?php echo $row['r_title']; ?></td>
        <td><?php echo $row['r_num_r'].' + '.$row['r_num_l']; ?></td>
        <td><?php echo $row['r_cost']/100; ?> руб.</td>
        <td class="td_control"><input type="button" value="Работа с заказом" class="b_orderwork ui-button ui-state-default ui-corner-all" id="<?php echo $row['id']; ?>"></td>

    </tr>
    <?php } ?>


</table>
