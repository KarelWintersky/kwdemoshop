<?php
session_start();
require_once "lib_shop.php";
global $CONFIG;
unset($product);
$id = $_GET['id'];
$product = LoadGoods($id);

$colors = explode(',',$product["colors"]);
$optpwr = explode(',',$product["opt_powers"]);
$basecurves = explode(',',$product["basecurves"]);
$axis = explode(',',$product["axis"]);
$cylinder = explode(',',$product["cylinder"]);

if ($product["feature"]!="") $product["feature"] = $product["feature"].'. ';
?>
<head>
    <title>Заказать <?php echo $product["title"];?></title>
    <link href="core/order.css" rel="stylesheet" type="text/css" media="screen"/>
</head>

<body>

<form name="product_form_<?php echo $id; ?>">
<div style="float: left; width: 550px;">
    <table width="100%">
        <tr>
            <td colspan="3">
                <div class="product_title"><?php echo $product["title"];?></div>
            </td>
            <td align="right">
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top" align="center">
                <img class="preview" src="core/image_show.php?id=<?php echo $product["preview_id"]?>" height="180" width="240"/>
            </td>
            <td colspan="3">
                <div class="char">Режим ношения: <?php echo GetRefData('ref_mow',$product["mow"]); ?></div>
                <div class="char">Диаметр: <?php echo $product["diameter"];?> мм.</div>
                <div class="char"><?php echo $product["feature"];?>Влагосодержание:&nbsp;<?php echo $product["humidity"];?>&nbsp;%</div>
                <div class="char">Упаковка <?php echo $product["lenses_in_box"]; ?> <?php echo GetHumanFriendlyCounter($product["lenses_in_box"],'линза','линзы','линз')?></div>
                <div class="char">Цена за упаковку:&nbsp;<?php print(PrintPrice($product["price_box"],"RU","show"));?></div>
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
                <span class="field_label">Радиус кривизны</span>
            </td>
            <td width="20%">
                <select id="basecurve_right_<?php echo $id; ?>" onChange="syncSelection('basecurve_right_<?php echo $id; ?>','basecurve_left_<?php echo $id; ?>')">
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
                <span class="field_label">Оптическая сила</span>
            </td>
            <td width="20%">
                <select id="optpower_right_<?php echo $id; ?>" onChange="syncSelection('optpower_right_<?php echo $id; ?>','optpower_left_<?php echo $id; ?>')">
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
                <span class="field_label">Цвет</span>
            </td>
            <td width="20%">
                <select id="color_right_<?php echo $id; ?>" onChange="syncSelection('color_right_<?php echo $id; ?>','color_left_<?php echo $id; ?>')">
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
                <span class="field_label">Ось</span>
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
                <span class="field_label">Цилиндр</span>
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

        <!-- Количество -->
        <tr>
            <td width="30%">
                <span class="field_label">Количество</span>
            </td>
            <?php /* правый глаз, он же основное количество для сопутствующих товаров */?>
            <td width="20%">
                <table border="0" style="margin-left: -3px;"><tr>
                    <td><input type="text" id="product_num_right_<?php echo $id; ?>" name="product_num_right_<?php echo $id; ?>" value="1" style="width: 58px;" /></td>
                    <td>
                        <div style="width: 15px; margin: 0px;">
                            <a href="javascript:f_change_num(document.product_form_<?php echo $id; ?>.product_num_right_<?php echo $id; ?>,'1',0,null);"><img border="0" src="../images/nup.gif"></a>
                            <a href="javascript:f_change_num(document.product_form_<?php echo $id; ?>.product_num_right_<?php echo $id; ?>,'0',0,null);"><img border="0" src="../images/ndown.gif"></a>
                        </div>
                    </td>
                </tr></table>
            </td>
            <?php /* левый глаз */ ?>
            <td colspan="2">
                <?php if ($product["type"]==1) {  /* левый только для оптических линз (и в будущем очков) */?>
                <table border="0" style="margin-left: -3px;"><tr>
                    <td><input type="text" id="product_num_left_<?php echo $id; ?>" name="product_num_left_<?php echo $id; ?>" value="0" style="width: 58px;" /></td>
                    <td>
                        <div style="width: 15px; margin: 0px;">
                            <a href="javascript:f_change_num(document.product_form_<?php echo $id; ?>.product_num_left_<?php echo $id; ?>,'1',0,null);"><img border="0" src="../images/nup.gif"></a>
                            <a href="javascript:f_change_num(document.product_form_<?php echo $id; ?>.product_num_left_<?php echo $id; ?>,'0',0,null);"><img border="0" src="../images/ndown.gif"></a>
                        </div>
                    </td>
                </tr></table>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="right">
                <div id="result_<?php echo $id; ?>">
                    <input type="button" id="add_button_<?php echo $id; ?>" value="Добавить в корзину" onClick="ajaxOrder(this.form,<?php echo $id; ?>);return false;" name="product_request">
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
            </td>
        </tr>
    </table>
</div>

<div class="product_text" style="text-align:justify; overflow: auto; padding-top: 32px; float: right; width: 250px; height: 438px;"><?php echo $product["description"];?>
</div>

</div>

<div style="display:none">
    <input type="text" id="product_id_<?php echo $id; ?>" value="<?php echo $product["id"]; ?>">
    <input type="text" id="price_box_<?php echo $id; ?>" value="<?php echo $product["price_box"]; ?>">
    <input type="text" id="type_<?php echo $id; ?>" value="<?php echo $product['type']; ?>">
    <input type="text" id="producer_<?php echo $id; ?>" value="<?php echo $product['producer']; ?>">
</div>

</form>

</body>












