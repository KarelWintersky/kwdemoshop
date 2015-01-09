<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");


// это модуль редактирования ленты новостей (акций)
// таблица newslist отличается от articles только тремя дополнительными полями:
// display_start и display_end - дата начала и конца трансляции новости
// rating - т.е. популярность новости. Можно задавать в окне редактирования.

require_once "lib_core.php";

$link = ConnectDB();
$req = "SELECT * FROM offerslist ORDER BY id DESC";
$result = mysql_query($req) or Die("Невозможно получить список статей из базы");
$num_offers = mysql_num_rows($result);
for ($i=0;$i<$num_offers;$i++)
{
    $one_offer = mysql_fetch_assoc($result);
    $id = $one_offer["id"];
    $offers_list[$id]=$one_offer;
}
mysql_close($link);
?>
<head>
    <title>Список рекламных акций</title>
    <style type="text/css">
        td {text-align:center;}
    </style>

    <script type="text/javascript" src="highslide/highslide.js"></script>
    <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
    <link rel="stylesheet" type="text/css" href="admin.css" />
    <script type="text/javascript" src="kernel.js"></script>

    <script type="text/javascript" src="hltable.js"></script>
    <link rel="stylesheet" type="text/css" href="hltable.css">

</head>

<body>

<div id="admin_menu">
    <?php include "admin_menu.php"; ?>
</div>

<div id="content">

    <input type="button" name="NewOffer" value="Добавить акцию" onClick="document.location.href='offer_add.php'" />
    <br>
    Количество новостных акций в базе: <?php echo count($offers_list); ?><br>
    <table border="1" bordercolor="blue" width="99%" id="offers_list">
        <tr>
            <th rowspan="2">&nbsp;#&nbsp;</th>
            <th rowspan="2">Последняя правка</th>
            <th colspan="2">Период трансляции<br /></th>
            <th rowspan="2">Название</th>
            <th rowspan="2">Управление</th>
        </tr>
        <tr>
            <th>Начало</th>
            <th>Конец</th>
        </tr>
        <?php
        if (0==count($offers_list))
        {
            ?>
            <tr><td colspan="6" align="left">В базе нет записей о проводимых рекламных акциях</td></tr>
            <?php
        }
        else
            foreach ($offers_list as $id=>$entry)
            {
                ?>
                <tr>
                    <td width="10%" align="center">
                        <a href="#" onClick="link_to_offer(<?php echo $id; ?>);return false;">
                            <small><?php echo $id; ?></small>
                        </a>
                    </td>

                    <td align="center">
                        <?php Print(PrintTime($entry["time_modify"])); ?>
                        <br>
                        <small>[<?php echo $entry["user_modify"]?>]</small>
                    </td>

                    <td align="center">
                        <?php print(PrintDate($entry["display_start"])) ?>
                    </td>

                    <td align="center">
                        <?php Print(PrintDate($entry["display_end"])) ?>
                    </td>


                    <td align="left">
                        <?php echo stripslashes($entry["title"]); ?>
                    </td>

                    <td>
                        <a href="offer_show.php?id=<?php echo $entry["id"]; ?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax', align:'center'} )">
                            Показать информацию о рекламной акции
                        </a><br>
                        <br>
                        <a href="offer_edit.php?id=<?php echo $id; ?>">Редактировать рекламную акцию</a><br>
                        <?php
                        if ($entry['deleted']) print('<span class="warning">Помечено на удаление</span><br>');
                        if (IsShowNow($entry)) print('<span class="info">Отображается на сайте сейчас!</span><br>');
                        ?>
                    </td>
                </tr>
                <?php
            }
        ?>
    </table>
</div>
<script type="text/javascript">
    highlightTableRows("offers_list","hoverRow");
</script>
</body>



