<?php

// вызывается аяксом с sortby=...
// - id - по умолчанию на загрузке
// - name - по имени
// - dateold - по дате добавления (старые первые)
// - datenew - по дате добавление (новые первые)
// - price - по цене
// - popular - по популярности

require_once "lib_shop.php";
session_start();

if (!$_SESSION['is_admin']) header("Location: ../index.php");


$sort_order = IsSet($_GET['order']) ? $_GET['order'] : ' ASC ';
$sort_by = IsSet($_GET["sortby"]) ? $_GET["sortby"] : 'id';

$market_content = LoadMarketAdmin($sort_by,$sort_order);
?>
<body>
<table border="1" width="100%" id="product_list">
    <tr><td></td></tr>
    <?php
    if (0==count($market_content))
    {
        ?>
        <tr><td colspan="2">Раздел магазина пуст!</td></tr>
        <?
    }
    else {
        $all_producers = LoadReference("ref_producer");
        echo '<tr><th>ID:</th><th>Производитель & Название';
        echo "<br><small>Сортировка: $sort_by, порядок: $sort_order</small>";
        echo '</th><th>Последняя правка</th><th>Цена</th><th>Рейтинг</th><th>Управление</th></tr>';
        foreach ($market_content as $id=>$entry) { ?>
            <tr>
                <td>
                    <?php echo $entry["id"];
                    if ($entry["image_id"]!=0) { ?>
                        <a href="image_show.php?id=<?php echo $entry["image_id"]?>" onclick="return hs.expand(this)"><img src="../images/insertim.gif" border="0" align="top"></a>
                        <?php } ?>
                </td>
                <td class="l">
                    &nbsp;<?php echo $all_producers[$entry["producer"]];?> » <?php echo $entry["title"];?>
                </td>
                <td>
                    <small><?php Print(PrintTime($entry["time_modify"]));?></small>
                </td>
                <td>
                    <?php Print(PrintPrice($entry["price_box"],"RU",'show')); ?>
                </td>
                <td>
                    <?php echo $entry["popular"] ?>
                </td>
                <td>
                    <input type="button" name="GetLink" value="INFO" onClick="window.open('goods_show.php?id=<?php echo $entry["id"]?>','','scrollbars=1,width=830,height=650,top=60,left=60');return false;" /><br>
                    <input type="button" name="GetLink" value="EDIT" onClick="document.location.href='goods_edit.php?id=<?php echo $entry["id"]?>'" /><br>
                    <?php
                    if ($entry['deleted']) print('<span class="warning">Товар помечен на удаление </span>');
                    ?>
                </td>
            </tr>
            <!--
    <td width="124">Всего продано: <?php echo $entry["sold"];?> </td>
    <td width="124">Дата добавления: <?php Print(PrintTime($entry["time_create"]));?>&nbsp;</td>
    <td width="124">Последняя правка: <?php Print(PrintTime($entry["time_modify"]));?>&nbsp;</td>
    <td align="left">Управление:</td>
-->
            <? } // end foreach

    } ?>
</table>

</body>






