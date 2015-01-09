<?php
session_start();
require_once "../lib_shop.php";
global $CONFIG;
unset($product);
$id = $_GET['id'];

$link = ConnectDB();
$q = "SELECT * FROM market WHERE (id=$id)";
$result = mysql_query($q) or Die("Невозможно получить запись о товаре из базы данных,<br> [$q]");
$product = mysql_fetch_assoc($result);
$product["description"] = stripslashes($product["description"]);
$product["title"]       = stripslashes($product["title"]);
$product["short_info"]  = stripslashes($product["short_info"]);

$colors = explode(',',$product["colors"]);
$optpwr = explode(',',$product["opt_powers"]);
$basecurves = explode(',',$product["basecurves"]);
$axis = explode(',',$product["axis"]);
$cylinder = explode(',',$product["cylinder"]);



if ($product["feature"]!="") $product["feature"] = $product["feature"].'. ';
?>
<div style="float: left; width: 550px;">
    <table width="100%">
        <tr>
            <td colspan="3">
                <div style="text-align:left;color: red;font-weight: bold;padding-left: 18px;"><?php echo $product["title"];?></div>
            </td>
            <td align="right">
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top" align="center">
                <img style="border: 0px;" src="image_show.php?id=<?php echo $product["preview_id"]?>" height="180" width="240"/>
            </td>
            <td colspan="3">
                <div style="text-align:left;padding-bottom: 5px; padding-left: 15px;">Режим ношения: <?php echo GetRefData('ref_mow', $product["mow"]); ?></div>
                <div style="text-align:left;padding-bottom: 5px; padding-left: 15px;">Диаметр: <?php echo $product["diameter"];?> мм.</div>
                <div style="text-align:left;padding-bottom: 5px; padding-left: 15px;"><?php echo $product["feature"];?>Влагосодержание:&nbsp;<?php echo $product["humidity"];?>&nbsp;%</div>
                <div style="text-align:left;padding-bottom: 5px; padding-left: 15px;">Упаковка <?php echo $product["lenses_in_box"]; ?> <?php echo GetHumanFriendlyCounter($product["lenses_in_box"],'линза','линзы','линз')?></div>
                <div style="text-align:left;padding-bottom: 5px; padding-left: 15px;">Цена за упаковку:&nbsp;<?php print(PrintPrice($product["price_box"],"RU","show"));?></div>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <hr>
            </td>
        </tr>
        <!-- какой у нас тип товара? -->
        <?php if ($product["type"]==1) { /* 1 - линзы */ ?>
        <tr>
            <td width="30%">
            </td>
            <td width="20%" height="30px">
                <span style="font-weight: 600;">Правый</span>
            </td>
            <td colspan="2">
                <span style="font-weight: 600;">Левый</span>
            </td>
        </tr>
        <?php } ?>
        <!-- Базовая кривизна -->
        <?php if (strlen($product["basecurves"])>0) { ?>
        <tr>
            <td width="30%">
                <span>Радиус кривизны</span>
            </td>
            <td width="20%">
                <select id="basecurve_right_<?php echo $id; ?>">
                    <?php $ref_basecurves = LoadReference('ref_basecurve');
                    foreach ($basecurves as $v) echo '<option value="'.$v.'">'.$ref_basecurves[$v].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="basecurve_left_<?php echo $id; ?>">
                    <?php $ref_basecurves = LoadReference('ref_basecurve');
                    foreach ($basecurves as $v) echo '<option value="'.$v.'">'.$ref_basecurves[$v].'</option>';
                    ?></select>
            </td>
        </tr>
        <?php } ?>
        <!-- Оптическая сила -->
        <?php if (strlen($product["opt_powers"])>=1) {  ?>
        <tr>
            <td width="30%">
                <span>Оптическая сила</span>
            </td>
            <td width="20%">
                <select id="optpower_right_<?php echo $id; ?>">
                    <?php $ref_op = LoadReference('ref_opticpower');
                    foreach ($optpwr as $v) echo '<option value="'.$v.'">'.$ref_op[$v].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="optpower_left_<?php echo $id; ?>">
                    <?php $ref_op = LoadReference('ref_opticpower');
                    foreach ($optpwr as $v) echo '<option value="'.$v.'">'.$ref_op[$v].'</option>';
                    ?></select>
            </td>
        </tr>
        <?php } ?>
        <!-- Цвета -->
        <?php if (strlen($product["colors"])>1) { /*(count($colors)>=1) - более правильное условие, но там надо в бд править пробелы */ ?>
        <tr>
            <td width="30%">
                <span>Цвет</span>
            </td>
            <td width="20%">
                <select id="color_right_<?php echo $id; ?>">
                    <?php $ref_colors = LoadReference('ref_colors');
                    foreach ($colors as $v) echo '<option value="'.$v.'">'.$ref_colors[$v].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="color_left_<?php echo $id; ?>">
                    <?php $ref_colors = LoadReference('ref_colors');
                    foreach ($colors as $v) echo '<option value="'.$v.'">'.$ref_colors[$v].'</option>';
                    ?></select>
            </td>
        </tr>
        <?php } ?>
        <!-- Оптическая ось -->
        <?php if (strlen($product["axis"])>0) { ?>
        <tr>
            <td width="30%">
                <span>Ось</span>
            </td>
            <td width="20%">
                <select id="axis_right_<?php echo $id; ?>">
                    <?php $ref_axis = LoadReference('ref_axis');
                    foreach ($axis as $vaxis) echo '<option value="'.$vaxis.'">'.$ref_axis[$vaxis].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="axis_left_<?php echo $id; ?>">
                    <?php $ref_axis = LoadReference('ref_axis');
                    foreach ($axis as $vaxis) echo '<option value="'.$vaxis.'">'.$ref_axis[$vaxis].'</option>';
                    ?></select>
            </td>
        </tr>
        <?php } ?>
        <!-- Цилиндр -->
        <?php if (strlen($product["cylinder"])>0) { ?>
        <tr>
            <td width="30%">
                <span>Цилиндр</span>
            </td>
            <td width="20%">
                <select id="cylinder_right_<?php echo $id; ?>">
                    <?php $ref_cylinder = LoadReference('ref_cylinder');
                    foreach ($cylinder as $vcylinder) echo '<option value="'.$vcylinder.'">'.$ref_cylinder[$vcylinder].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="cylinder_left_<?php echo $id; ?>">
                    <?php $ref_cylinder = LoadReference('ref_cylinder');
                    foreach ($cylinder as $vcylinder) echo '<option value="'.$vcylinder.'">'.$ref_cylinder[$vcylinder].'</option>';
                    ?></select>
            </td>
        </tr>

        <?php } ?>

    </table>
</div>

<div style="text-align:justify; overflow: auto; padding-top: 32px; float: right; width: 650px;text-indent: 2em;font-size: normal;padding-left: 20px;padding-right: 20px;max-height: 100px;"><?php echo $product["description"];?>
</div>


<div style="display:none">
    <input type="text" id="product_id_<?php echo $id; ?>" value="<?php echo $product["id"]; ?>">
    <input type="text" id="price_box_<?php echo $id; ?>" value="<?php echo $product["price_box"]; ?>">
    <input type="text" id="type_<?php echo $id; ?>" value="<?php echo $product['type']; ?>">
    <input type="text" id="producer_<?php echo $id; ?>" value="<?php echo $product['producer']; ?>">
</div>

