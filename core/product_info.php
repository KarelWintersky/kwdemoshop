<?php
require_once "lib_shop.php";
unset($entry);
$id = $_GET['id'];
$entry = LoadGoods($id);
?>
<head>
    <title><?php echo $entry["title"];?></title>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">
    <style type="text/css">
        div.product_title {
            color: blue;
            font-size: 110%
        }
        div.product_text {
            font-size: normal;
        }
        a {
            text-decoration:none;
        }
    </style>
</head>
<body>
<table border="0" cellpadding="3" height="90%">
    <tr>
        <td width="130" valign="top" align="center">
            <a href="image_show.php?id=<?php echo $entry["image_id"]?>" rel="lightbox">
                <img src="image_preview.php?id=<?php echo $entry["preview_id"]?>"/><br><small> >>Увеличить<< </small>
            </a>
        </td>
        <td valign="top" align="justify">
            <div class="product_title"><?php echo $entry["title"];?></div>
            <hr noshade color="#cccccc">
            <div class="product_text"><?php echo $entry["description"];?></div>
            <hr noshade color="#cccccc">
            <div class="product_info">

                <table border="0" bgcolor="#eeeeee" width="45%" style="float:left">
                    <tr><td>Влагосодержание: </td><td><?php echo $entry["humidity"]; ?> %</td></tr>
                    <tr><td>Диаметр: </td><td><?php echo $entry["diameter"]; ?></td></tr>

                    <tr><td>Базовая кривизна: </td><td><?php echo GetRefData('ref_basecurve',$entry["basecurve"]); ?></td></tr>
                    <tr><td>Подкраска: </td><td><?php echo GetRefData('ref_colors',$entry["color"]); ?></td></tr>
                    <tr><td>Оптическая сила: </td><td>от <?php echo GetRefData('ref_opticpower',$entry["opt_power_min"]); ?> до <?php echo GetRefData('ref_opticpower',$entry["opt_power_max"]); ?></td></tr>
                </table>
                <table border="0" bgcolor="#eeeeee"  width="45%" style="float:right">
                    <tr><td>Цена за штуку: </td><td>&nbsp;</td><td><?php print(PrintPrice($entry["price_one"],"RU","show"));?></td></tr>
                    <tr><td>Цена за упаковку: </td><td>&nbsp;</td><td><?php print(PrintPrice($entry["price_box"],"RU","show"));?></td></tr>
                    <tr><td colspan="3">Упаковка <?php echo $entry["lenses_in_box"]; ?> линз(ы)</td></tr>
                </table>
            </div>
        </td>
    </tr>
</table>
<div style="text-align:right" id="result">
    <input type="button" name="Return_to_market" value="Закрыть окно" onClick="window.close(self);return false;">
</div>
</body>
