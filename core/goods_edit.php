<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

require_once "lib_shop.php";
global $CONFIG;
$id = IsSet($_GET['id']) ? $_GET['id'] : "0";
$entry = LoadGoods($_GET['id']);
$entry_id = $entry['id'];
//  $checked_style = ' style="font-weight:bold;color:red"';
$checked_style = ' style="color:red"';

$sw = new SPAW_Wysiwyg('GoodsDescription',stripslashes($entry['description']));
?>
<head>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">
    <link type="text/css" rel="stylesheet" href="admin.css">
    <script type="text/javascript" src="kernel.js"></script>
    <style>
        nobr {
            padding: 0px;
        };
        ul.ul_list {
            list-style-position: inside;
            float: left;
        }
        ul.ul_list li {
            float: left;
            list-style: none;
        }
        ul.ul_list li.optic{
            width: 5em;
        }
    </style>

    <script>
        function cb(span)
        {
//    span.parentNode.style["fontWeight"] = span.checked ? "bold" : "";
            span.parentNode.style["color"] = span.checked ? "red" : "";
        }
        function SetProductId(from,trg)
        {
            si = document.getElementById(from).selectedIndex;
            val = document.getElementById(from).options[si].value;
            document.getElementById(trg).value = 'ID: '+val;
        }
    </script>
</head>
<body>

<form enctype="multipart/form-data" name="newgoods" action="goods_action_update.php" method="POST">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />

<table border="1" bordercolor="red">
<tr>
    <td width="270px">Тип товара: </td>
    <td>
        <select id="producttype" name="producttype" onChange="SetProductId('producttype','product_type_id')">
            <?php $ref_producttype = LoadReference('ref_producttype');
            foreach ($ref_producttype as $i=>$v)
                if ($i==$entry["type"]) echo '<option value="'.$i.'" selected>'.$v.'</option>\n';
                else echo '<option value="'.$i.'">'.$v.'</option>\n';
            ?>
            <input id="product_type_id" value="ID: <?php echo $entry["type"]; ?>" readonly size="5">
    </td>
</tr>

<tr>
    <td>Название товара:</td>
    <td><input type="text" name="GoodsName" size="60" maxlenght="60" class="" value="<?php echo $entry['title'];?>">
        Производитель:
        <select name="producer">
            <?php $ref_producer = LoadReference('ref_producer');
            foreach ($ref_producer as $i=>$v)
                if ($i==$entry["producer"]) echo '<option value="'.$i.'" selected>'.$v.'</option>';
                else echo '<option value="'.$i.'">'.$v.'</option>';
            ?>
        </select>
    </td>
</tr>
<tr>
    <td>Изображение:</td>
    <td>
        <input type="text" name="image_link" value="<?php echo $CONFIG['url_showtn'].$entry['preview_id'];?>" size="60" maxlenght="60" style="border:1px solid #FF0000; background:transparent;">
        <input type="button" name="ShowGallery" value="Выбрать другую картинку >>>" onClick="window.open('image_list.php','','scrollbars=1,width=830,height=650,top=60,left=60');return false;">
        ID: <input type="text" name="image_id" size="4" readonly value="<?php echo $entry['preview_id']; ?>" style="background: transparent; border:0px solid #ffffff">
        Превью: <a href="image_preview.php?id=<?php echo $entry['preview_id']; ?>" rel="lightbox" id="image_here_preview"><img src="../images/insertim.gif" id="image_icon_" align="top"></a>
        Изображение: <a href="image_show.php?id=<?php echo $entry['image_id']; ?>" rel="lightbox" id="image_here_full"><img src="../images/insertim.gif" id="image_icon_" align="top"></a>
    </td>
</tr>

<tr>
    <td>Введите цену в рублях:</td>
    <td>
        <?php
        $price = $entry['price_box'];
        $price_lo = $price%100;
        $price_hi = floor($price/100);
        ?>
        Цена за упаковку:&nbsp;&nbsp;
        <input type="text" name="price_box_ru_hi" size="7" maxlenght="7" class="" value="<?php echo $price_hi; ?>" tabindex="6"> рублей
        <input type="text" name="price_box_ru_lo" size="7" maxlenght="7" class="" value="<?php echo $price_lo; ?>" tabindex="7"> копеек.
    </td>
</tr>

<tr>
    <td>Укажите:
    </td>
    <td>
        <? /*          Длительность использования:&nbsp;
          <select name="dou" tabindex="8">
    $ref_dou = LoadReference('ref_dou');
foreach ($ref_dou as $i=>$v)
  if ($i==$entry["dou"]) echo '<option value="'.$i.'" selected>'.$v.'</option>';
  else echo '<option value="'.$i.'">'.$v.'</option>';

          </select>
          &nbsp;&nbsp; */ ?>
        Режим ношения:&nbsp;
        <select name="mow" tabindex="9">
            <?php $ref_mow = LoadReference('ref_mow');
            foreach ($ref_mow as $i=>$v)
                if ($i==$entry["mow"]) echo '<option value="'.$i.'" selected>'.$v.'</option>';
                else echo '<option value="'.$i.'">'.$v.'</option>';
            ?>
        </select>
        &nbsp;&nbsp;
        Цветность:&nbsp;
        <select name="chroma" tabindex="10">
            <?php $ref_chroma = LoadReference('ref_chroma');
            foreach ($ref_chroma as $i=>$v)
                if ($i==$entry["chroma"]) echo '<option value="'.$i.'" selected>'.$v.'</option>';
                else echo '<option value="'.$i.'">'.$v.'</option>';
            ?>
        </select>
        Влагосодержание: <input type="text" name="humidity" size="4" maxlenght="4" value="<?php echo $entry["humidity"]; ?>" tabindex="12"> %
        &nbsp;&nbsp;&nbsp;Диаметр: <input type="text" name="diameter" size="3" maxlenght="3" value="<?php echo $entry["diameter"]; ?>" tabindex="13">
        <hr color="#BBBBBB">
        Ключевая особеность товара: <input type="text" name="feature" size="30" maxlength="30" value="<?php echo $entry["feature"]; ?>">

        &nbsp;&nbsp;&nbsp;Линз в упаковке: <input type="text" name="lenses_in_box" size="3" maxlenght="3" value="<?php echo $entry["lenses_in_box"]; ?>" tabindex="14">

    </td>
</tr>
<tr>
    <td colspan="2"><hr width="80%"></td>
</tr>
<tr>
    <td>Оптическая сила:</td>
    <td>
        <?php
        $optpwrs_all = LoadReference("ref_opticpower");  // загрузили в лист ВСЕ возможные чекбоксы
        $optpwrs_this = explode(',',$entry['opt_powers']); // загрузили отмеченные
        foreach ($optpwrs_all as $oi=>$ov) $optpwrs_incstr[$oi]=""; // сделали пустую строчку для параметра чекед
        foreach ($optpwrs_this as $oi=>$ov) $optpwrs_incstr[$ov]=" checked";
        foreach ($optpwrs_this as $oi=>$ov) $optpwrs_nobr[$ov]=$checked_style;
        echo '<ul class="ul_list">';
        foreach ($optpwrs_all as $oi=>$ov)
            echo '
    <li class="optic">
      <nobr'.$optpwrs_nobr[$oi].'>
        <input
          type="checkbox"
          onClick="cb(this)"
          name="optpwr[]"
          id="o'.$oi.'" value="'.$oi.'"'.$optpwrs_incstr[$oi].'>'.$ov.'&nbsp;<nobr></li>'."\n";
        ?>
        </ul></td>
</tr>

<tr>
    <td>Цвета:</td>
    <td>
        <?php
// ЦВЕТА
        $colors_all = LoadReference("ref_colors");
        $colors_this = explode(',',$entry["colors"]);
        foreach ($colors_all as $ci=>$cv) $colors_incstr[$ci]=""; // сделали пустую строчку для параметра чекед
        foreach ($colors_this as $ci=>$cv) $colors_incstr[$cv]=" checked";
        foreach ($colors_this as $ci=>$cv) $colors_nobr[$cv]=$checked_style;
        foreach ($colors_all as $ci=>$cv)
        {
            echo '
      <span>
        <nobr'.$colors_nobr[$ci].'>
          <input
          type="checkbox"
          onClick="cb(this)"
          name="colors[]"
          id="c'.$ci.'" value="'.$ci.'"'.$colors_incstr[$ci].'>'.$cv.'&nbsp;<nobr></span>'."\n";
        }
        ?>
    </td>
</tr>

<tr>
    <td>Базовая кривизна:</td>
    <td>
        <?php
// БАЗОВАЯ КРИВИЗНА
        $bc_all = LoadReference("ref_basecurve");
        $bc_this = explode(',',$entry["basecurves"]);
        foreach ($bc_all as $bi=>$bv) $bc_incstr[$bi]=""; // сделали пустую строчку для параметра чекед
        foreach ($bc_this as $bi=>$bv) $bc_incstr[$bv]=" checked";
        foreach ($bc_this as $bi=>$bv) $bc_nobr[$bv]=$checked_style;


        foreach ($bc_all as $bi=>$bv)
        {
            echo '
       <span>
         <nobr'.$bc_nobr[$bi].'>
          <input
          type="checkbox"
          onClick="cb(this)"
          name="basecurves[]"
          id="c'.$bi.'" value="'.$bi.'"'.$bc_incstr[$bi].'>'.$bv.'&nbsp;<nobr></span>'."\n";

        }
        ?>
    </td>
</tr>
<!-- астигматика -->
<tr>
    <td rowspan="2">Укажите эти параметры только для <br>астигматических линз</td>
    <td>
        <ul class="ul_list">
            <li><b>Ось (axis):   </b></li>
            <?php
// AXIS (ось)
            $axis_all = LoadReference("ref_axis");
            $axis_this = explode(',',$entry["axis"]);
            foreach ($axis_all as $ai=>$av) $axis_incstr[$ai]=""; // сделали пустую строчку для параметра чекед
            foreach ($axis_this as $ai=>$av) $axis_incstr[$av]=" checked";
            foreach ($axis_this as $ai=>$av) $axis_nobr[$av]=$checked_style;

            foreach ($axis_all as $ai=>$av)
            {
                echo '<span><nobr'.$axis_nobr[$ai].'><input type="checkbox" onClick="cb(this)" name="axis[]" id="c'.$ai.'" value="'.$ai.'"'.$axis_incstr[$ai].'>'.$av.'&nbsp;<nobr></span>'."\n";}
            ?>
        </ul>
    </td>
</tr>
<tr>
    <td>
        <ul class="ul_list">
            <li><b>Цилиндр (cyl):   </b></li>
            <?php
// CYLINDER (цилиндр)
            $cylinder_all = LoadReference("ref_cylinder");
            $cylinder_this = explode(',',$entry["cylinder"]);
            foreach ($cylinder_all as $yi=>$yv) $cylinder_incstr[$yi]=""; // сделали пустую строчку для параметра чекед
            foreach ($cylinder_this as $yi=>$yv) $cylinder_incstr[$yv]=" checked";
            foreach ($cylinder_this as $yi=>$yv) $cylinder_nobr[$yv]=$checked_style;

            foreach ($cylinder_all as $yi=>$yv)
            {
                echo '
        <span>
        <nobr'.$cylinder_nobr[$yi].'>
        <input
          type="checkbox"
          onClick="cb(this)"
          name="cylinder[]"
          id="c'.$yi.'" value="'.$yi.'"'.$cylinder_incstr[$yi].'>'.$yv.'&nbsp;<nobr></span>'."\n";

            }
            ?>
    </td>
</tr>



<!-- краткая инфа о товаре -->
<tr>
    <td colspan="2"><hr width="80%"></td>
</tr>

<tr>
    <td>Краткое описание товара:</td>
    <td>
        <div style="float:left">
            <textarea name="short_info" cols="70" rows="2" tabindex="15"><?php echo $entry["short_info"] ?></textarea>
            <br><small><i>Введите здесь краткое описание товара - оно будет показываться в списке товаров.</i></small>
        </div>
        <div style="float:left;margin-left:20px">
            Отметьте популярность товара<br><small>(число от -100 до 100)</small>
            <input type="text" name="popular" size="10" maxlenght="10" class="" value="<?php echo $entry['popular']; ?>">
        </div>
    </td>
</tr>

<tr>
    <td colspan="2">Введите описание товара:</td>
</tr>
<tr>
    <td colspan="2">
        <?php
        $sw->show();
        ?>
    </td>
</tr>

<tr>
    <td colspan="2">
        <div style="float:left;margin-left:20px">
            <div id="remove_controls">
                <div name="DeleteGoods" style="<?php if ($entry["deleted"]==0) echo 'display: block'; else echo 'display: none'?>">
                    <input type="button" name="bDeleteGoods" value="Пометить товар на удаление"
                           onClick="showAnyFile('goods_action_delete.php?id=<?php echo $id ?>','remove_controls')">
                </div>
                <div name="UnDeleteGoods" style="<?php if ($entry["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
                    <input type="button" name="bUnDeleteGoods" value='Снять пометку "на удаление"'
                           onClick="showAnyFile('goods_action_undelete.php?id=<?php echo $id ?>','remove_controls')">
                </div>
                <div name="PurgeGoods" style="<?php if ($entry["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
                    <input type="button" name="bPurgeGoods" value='Окончательно удалить товар из базы'
                           onClick="showAnyFile('goods_action_purge.php?id=<?php echo $id ?>','remove_controls')">
                </div>

            </div>
        </div>
        <input style="float:right;margin-right:20px" type="submit" value="Обновить информацию" name="UploadGoods"/>
    </td>
</tr>
</table>

</form>
<hr>

<div align="center"><input type="button" name="Return_to_market" value="Вернутся к списку товаров" onClick="document.location.href='goods.php';return false;"></div>
</body>
</html>
















