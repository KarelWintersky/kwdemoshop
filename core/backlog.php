<?php
/*
Этот модуль написан позже всех - в нем уже есть некоторое подобие порядка
и попытка создать модульную структуру проекта.

Гораздо лучше эта модульная структура реализована в проекте (так и не сделанном, почему - это
отдельная история) сайта ЕВРОХИМ. Тем не менее, сырцы проекта "Еврохим" сохранились и даже
не попадают под NDA :)

Этот модуль писался в первую очередь для ЕВРОХИМА, сюда он перенесен для удобства, но...
... заказчики этот интерфейс не оценили и, насколько я могу судить по логам, не использовали.
Привычнее было получать заказы на почту, копипастить в эксель ручками, итд итп.


*/
session_start();
require_once "backlog.lib.php";
$module_name = "backlog";
$module_title = "Консоль менеджера";
?>

<html>
<head>
    <title><?php echo $module_title; ?></title>

    <link href="<?php echo $module_name; ?>/adm.layout.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $module_name; ?>/adm.styles.css" rel="stylesheet" type="text/css">
    <!-- Core files -->
    <script type="text/javascript" src="jquery/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" media="all" href="jquery/jquery.jgrowl.css">
    <script type="text/javascript" src="jquery/jquery.jgrowl.js"></script>

    <script src="jquery/jquery.alerts.js" type="text/javascript"></script>
    <link href="jquery/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen">
    <!-- UI -->
    <link type="text/css" href="jquery/ui/default.theme.css" rel="stylesheet" />
    <script type="text/javascript" src="jquery/ui/ui.core.js"></script>
    <!-- <script type="text/javascript" src="jquery/ui/ui.draggable.js"></script> -->
    <script type="text/javascript" src="jquery/ui/ui.resizable.js"></script>
    <script type="text/javascript" src="jquery/ui/ui.dialog.js"></script>
    <script type="text/javascript" src="jquery/ui/effects.core.js"></script>
    <script type="text/javascript" src="jquery/ui/effects.highlight.js"></script>
    <script type="text/javascript" src="jquery/ui/jquery.bgiframe.js"></script>
    <style type="text/css">
        .ui-button { outline: 0; margin:0; padding: .4em 1em .5em; text-decoration:none;  !important; cursor:pointer; position: relative; text-align: center; }
    </style>
    <!-- Skype -->
    <script type="text/javascript" no-src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>

    <script type="text/javascript" src="backlog/jq.backlog.js"></script>

</head>

<body id="<?php echo $module_name;?>_body">

<?php if (!$_SESSION['is_admin']) {
    include "admin/adm.loginform.tpl";
} else { ?>

<div id="content_wrapper">
    <div id="box_topic">
        <table border="1">
            <tr>
                <!-- <td><span id="timer_counter">0</span></td> -->
                <td><div>Сейчас: </div>
                    <div id="today_date"></div>
                    <div id="today_time"></div>
                </td>
                <td class="c">
                    Заказов в очереди:<br><span id="orders_count"></span>
                </td>
                <td>
                    <div>Заказы ждут уже:</div>
                    <div id="delta_time"></div>
                </td>
                <td>
                    <input type="button" value="Очередь заказов" id="console_reload">
                </td>
                <td>
                    <input type="button" value="История заказов" id="b_fullbacklog">
                </td>
                <td>
                    <input type="button" value="В админку" id="b_quitbacklog"><hr width="80%">
                    <input type="button" value="На сайт" id="b_gotosite">
                </td>
            </tr>
        </table>
    </div>
    <div id="content"></div>
    <div id="modal_orderwork"></div>
    <div id="modal_mailer">
        Функция временно недоступна
    </div>
    <div id="modal_productinfo">

    </div>
</div>

    <?php } ?>

</body>

</html>