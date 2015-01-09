<?php
session_start();
require_once "lib_shop.php";
unset($entry);
$cart = $_SESSION['cart'];
$cart_pos = $_GET['id'];   // позиция (номер записи) в корзине
$entry = $cart[$cart_pos];  // полная запись о товаре из корзинки

$id = $cart_pos;

$product = LoadGoods($entry["id"]); // информация о товаре из БД

// это мы развернем сериализованные строки в массивы
$colors = explode(',',$product["colors"]);
$optpwr = explode(',',$product["opt_powers"]);
$basecurve = explode(',',$product["basecurves"]);
$axis = explode(',',$product["axis"]);
$cylinder = explode(',',$product["cylinder"]);

$ref_basecurve = LoadReference('ref_basecurve');
$ref_op = LoadReference('ref_opticpower');
$ref_colors = LoadReference('ref_colors');
$ref_axis = LoadReference('ref_axis');
$ref_cylinder = LoadReference('ref_cylinder');


if ($product["feature"]!="") $product["feature"] = $product["feature"].'. ';
?>
<head>
    <title>Редактировать <?php echo $product["title"];?></title>
    <link href="core/order.css" rel="stylesheet" type="text/css" media="screen"/>
</head>

<body style="text-align:left">
<form name="product_form_<?php echo $id; ?>">
<div style="float: left; width: 550px;">
<table width="100%">
<tr>
    <td colspan="3">
        <div class="product_title"><?php echo $product["title"];?></div>
    </td>
    <td width="30%" align="right">
    </td>
</tr>
<tr>
    <td width="30%" valign="top" align="center">
        <img border="1" class="preview" src="core/image_show.php?id=<?php echo $product["preview_id"]?>" height="180" width="240"/>
    </td>
    <td colspan="3">
        <div class="char">Режим ношения: <?php echo GetRefData('ref_mow',$product["mow"]); ?></div>
        <div class="char">Диаметр: <?php echo $entry["diameter"];?> мм.</div>
        <div class="char"><?php echo $product["feature"];?>Влагосодержание:&nbsp;<?php echo $product["humidity"];?>&nbsp;%</div>
        <div class="char">Упаковка <?php echo $product["lenses_in_box"]; ?>&nbsp;<?php echo GetHumanFriendlyCounter($product["lenses_in_box"],'линза','линзы','линз')?></div>
        <div class="char">Цена за упаковку:&nbsp;<?php print(PrintPrice($product["price_box"],"RU","show"));?></div>
    </td>
</tr>
<tr>
    <td colspan="4">
        <hr>
    </td>
</tr>
<!-- какой у нас тип товара? -->
<?php if ($product["type"]==1) { /* 2 - сопутствующие товары */ ?>
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
        <select id="basecurve_right_<?php echo $id; ?>" _onChange="syncSelection('basecurve_right_<?php echo $id; ?>','basecurve_left_<?php echo $id; ?>')">
            <?php
            foreach ($basecurve as $vr)
                if ($vr!=$entry['bc_right']) echo '<option value="'.$vr.'">'.$ref_basecurve[$vr].'</option>';
                else echo '<option value="'.$vr.'" selected>'.$ref_basecurve[$vr].'</option>';?>
        </select>
    </td>
    <td colspan="2">
        <select id="basecurve_left_<?php echo $id; ?>">
            <?php
            foreach ($basecurve as $vl)
                if ($vl!=$entry['bc_left']) echo '<option value="'.$vl.'">'.$ref_basecurve[$vl].'</option>';
                else echo '<option value="'.$vl.'" selected>'.$ref_basecurve[$vl].'</option>';?>
        </select>
    </td>
</tr>
    <?php }; ?>
<!-- Оптическая сила -->
<?php if (strlen($product["opt_powers"])>0) {  ?>
<tr>
    <td width="30%">
        <span class="field_label">Оптическая сила</span>
    </td>
    <td width="20%">
        <select id="optpower_right_<?php echo $id; ?>" _onChange="syncSelection('optpower_right_<?php echo $id; ?>','optpower_left_<?php echo $id; ?>')">
            <?php
            foreach ($optpwr as $or)
                if ($or!=$entry['op_right']) echo '<option value="'.$or.'">'.$ref_op[$or].'</option>';
                else echo '<option value="'.$or.'" selected>'.$ref_op[$or].'</option>';
            ?></select>
    </td>
    <td colspan="2">
        <select id="optpower_left_<?php echo $id; ?>">
            <?php
            foreach ($optpwr as $ol)
                if ($ol!=$entry['op_left']) echo '<option value="'.$ol.'">'.$ref_op[$ol].'</option>';
                else echo '<option value="'.$ol.'" selected>'.$ref_op[$ol].'</option>';
            ?></select>
    </td>
</tr>
    <?php } ?>
<!-- Цвета -->
<?php if (strlen($product["colors"])>0) { ?>
<tr>
    <td width="30%">
        <span class="field_label">Цвет</span>
    </td>
    <td width="20%">
        <select id="color_right_<?php echo $id; ?>" _onChange="syncSelection('color_right_<?php echo $id; ?>','color_left_<?php echo $id; ?>')">
            <?php
            foreach ($colors as $cr)
                if ($cr!=$entry['color_right']) echo '<option value="'.$cr.'">'.$ref_colors[$cr].'</option>';
                else echo '<option value="'.$cr.'" selected>'.$ref_colors[$cr].'</option>';?>
        </select>
    </td>
    <td colspan="2">
        <select id="color_left_<?php echo $id; ?>">
            <?php
            foreach ($colors as $cl)
                if ($cl!=$entry['color_left']) echo '<option value="'.$cl.'">'.$ref_colors[$cl].'</option>';
                else echo '<option value="'.$cl.'" selected>'.$ref_colors[$cl].'</option>';?>
        </select>
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
        <select id="axis_right_<?php echo $id; ?>" _onChange="syncSelection('axis_right_<?php echo $id; ?>','axis_left_<?php echo $id; ?>')">
            <?php
            foreach ($axis as $ar)
                if ($ar!=$entry['axis_right']) echo '<option value="'.$ar.'">'.$ref_axis[$ar].'</option>';
                else echo '<option value="'.$ar.'" selected>'.$ref_axis[$ar].'</option>';?>
        </select>
    </td>
    <td colspan="2">
        <select id="axis_left_<?php echo $id; ?>">
            <?php
            foreach ($axis as $al)
                if ($al!=$entry['axis_left']) echo '<option value="'.$al.'">'.$ref_axis[$al].'</option>';
                else echo '<option value="'.$al.'" selected>'.$ref_axis[$al].'</option>';?>
        </select>
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
        <select id="cylinder_right_<?php echo $id; ?>" _onChange="syncSelection('cylinder_right_<?php echo $id; ?>','cylinder_left_<?php echo $id; ?>')">
            <?php
            foreach ($cylinder as $lr)
                if ($lr!=$entry['cylinder_right']) echo '<option value="'.$lr.'">'.$ref_cylinder[$lr].'</option>';
                else echo '<option value="'.$lr.'" selected>'.$ref_cylinder[$lr].'</option>';?>
        </select>
    </td>
    <td colspan="2">
        <select id="cylinder_left_<?php echo $id; ?>">
            <?php
            foreach ($cylinder as $ll)
                if ($ll!=$entry['cylinder_left']) echo '<option value="'.$ll.'">'.$ref_cylinder[$ll].'</option>';
                else echo '<option value="'.$ll.'" selected>'.$ref_cylinder[$ll].'</option>';?>
        </select>
    </td>
</tr>
    <?php } ?>

<tr>
    <td width="30%">
        <span class="field_label">Количество</span>
    </td>
    <td width="20%">
        <?php /* правый глаз, он же основное количество для сопутствующих товаров */?>
        <table border="0" style="margin-left: -3px;"><tr>
            <td><input type="text" id="product_num_right_<?php echo $id; ?>" name="product_num_right_<?php echo $id; ?>" value="<?php echo $entry['num_right']?>" style="width: 58px;" /></td>
            <td>
                <div style="width: 15px; margin: 0px;">
                    <a href="javascript:f_change_num(document.product_form_<?php echo $id; ?>.product_num_right_<?php echo $id; ?>,'1',0,null);"><img border="0" src="../images/nup.gif"></a>
                    <a href="javascript:f_change_num(document.product_form_<?php echo $id; ?>.product_num_right_<?php echo $id; ?>,'0',0,null);"><img border="0" src="../images/ndown.gif"></a>
                </div>
            </td>
        </tr></table>
    </td>
    <td colspan="2">
        <?php if ($product["type"]==1) { ?>
        <table border="0" style="margin-left: -3px;"><tr>
            <td><input type="text" id="product_num_left_<?php echo $id; ?>" name="product_num_left" value="<?php echo $entry['num_left']?>" style="width: 58px;" /></td>
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
            <input type="button" id="edit_button_<?php echo $id; ?>" value="Сохранить" onClick="ajaxOrder(this.form,<?php echo $id; ?>);return false;" name="product_request">
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

<div style="display:none">
    <input type="text" id="producer_<?php echo $id; ?>" value="<?php echo $entry['producer']; ?>">

    <input type="text" id="cart_pos_<?php echo $id; ?>" value="<?php echo $cart_pos; ?>">
    <input type="text" id="price_box_<?php echo $id; ?>" value="<?php echo $entry["price_box"]; ?>">
    <input type="text" id="type_<?php echo $id; ?>" value="<?php echo $entry['type']; ?>">
    <input type="text" id="product_id_<?php echo $id; ?>" value="<?php echo $entry["id"]; ?>">

</div>
</form>
</body>





