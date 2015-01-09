<?php
// goods_edit LIKE
require_once "lib_shop.php";
unset($entry);
$entry = LoadGoods($_GET['id']);
?>
<head>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">
</head>
<body>
<table border="1">
    <tr>
        <td width="124">
            <a href="image_show.php?id=<?php echo $entry["image_id"]?>" rel="lightbox">
                <img src="image_preview.php?id=<?php echo $entry["preview_id"]?>"/><br><small>Показать изображение</small>
            </a>
        </td>
        <td width="70%"><?php echo $entry["description"];?> </td>
    </tr>
    <tr>
        <td>Название товара:</td>
        <td><?php echo $entry["title"];?> </td>
    </tr>
    <tr>
        <td>Цена (за упаковку):</td>
        <td><?php Print(PrintPrice($entry["price_box"],"RU",'show')); ?> </td>
    </tr>

    <tr>
        <td>Популярность:</td>
        <td><?php echo $entry["popular"];?> </td>
    </tr>

    <tr>
        <td>Дата добавления:</td>
        <td><?php echo PrintTime($entry["time_create"]);?> </td>
    </tr>

    <tr>
        <td>Дата модификации:</td>
        <td><?php echo PrintTime($entry["time_modify"]);?> </td>
    </tr>

    <tr>
        <td>Всего продано:</td>
        <td><?php echo $entry["sold"];?>&nbsp;</td>
    </tr>

    <tr>
        <td>Всего заказано:</td>
        <td><?php echo $entry["requested"];?>&nbsp;</td>
    </tr>
    <?php
    if ($entry["deleted"]!=0) {
        ?>
        <tr>
            <td colspan="2">Товар помечен на удаление</td>
        </tr>
        <?php
    }
    ?>
</table>
<input type="button" name="Return_to_market" value="Закрыть окно" onClick="window.close(self);return false;">
</body>

