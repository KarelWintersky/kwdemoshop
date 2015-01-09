<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

require_once "lib_shop.php";

$id = IsSet($_GET['id']) ? $_GET['id'] : "0";
$sw = new SPAW_Wysiwyg('GoodsDescription');
$magic = NewMagicNumber();
?>
<head>
    <title>Редактор: товар интернет-магазина</title>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">
    <link type="text/css" rel="stylesheet" href="admin.css">

    <style type="text/css">
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
    <script src="/core/js/core.js"></script>
    <script src="/core/js/tinymce/tinymce.min.js"></script>
    <script src="/core/js/tinymce.config.js"></script>
    <script type="text/javascript">
        tinify(tiny_config['full'], 'area1'); //id!
    </script>

    <script>
        function cb(span)
        {
            span.parentNode.style["fontWeight"] = span.checked ? "bold" : "";
            span.parentNode.style["color"] = span.checked ? "red" : "black";
        }
        function RedCheckBoxes()
        {
            var all = document.getElementsByTagName('checkbox');
            for (var i=0; i<all.length; i++)
            {
                var item = all[i];
                if (item.getAttribute("checked"))
                {
                    item.style["fontWeight"] = "bold";
                    item.style["color"] = "red";
                }
            }
        }
        function SetProductId(from,trg,msg)
        {
            si = document.getElementById(from).selectedIndex;
            val = document.getElementById(from).options[si].value;
            document.getElementById(trg).value = 'ID: '+val;
        }
    </script>
</head>

<body>
<form enctype="multipart/form-data" name="newgoods" action="goods_action_insert.php" method="POST">
<table border="1" bordercolor="lightgray">
    <tr>
        <td>Тип товара: </td>
        <td>
            <select id="producttype" name="producttype" tabindex="1" onChange="SetProductId('producttype','product_type_id','product_type_msg')">
                <?php $ref_producttype = LoadReference('ref_producttype');
                foreach ($ref_producttype as $id=>$v) echo '<option value="'.$id.'">'.$v.'</option>';
                ?>
                <input id="product_type_id" value="ID: 1" readonly size="5">
        </td>
    </tr>
    <tr>
        <td>Введите название товара:</td>
        <td>
            <input type="text" name="GoodsName" size="60" maxlenght="60" class="" tabindex="2">
            <!-- производитель -->
            Производитель:
            <select name="producer" tabindex="3">
                <?php $ref_producer = LoadReference('ref_producer');
                foreach ($ref_producer as $id=>$v) echo '<option value="'.$id.'">'.$v.'</option>';
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Укажите ссылку на изображение:</td>
        <td>
            <input type="text" name="image_link" value="Обязательно выберите изображение из галереи..." size="40" maxlenght="40" style="border:1px solid #FF0000; background:transparent;" readonly> <!-- указать атрибут readonly в последней редакции -->
            <input type="button" name="ShowGallery" value="Выбрать >>>" onClick="window.open('image_list.php','','scrollbars=1,width=830,height=650,top=60,left=60');return false;">
            ID: <input type="text" name="image_id" size="4" readonly value="0" style="background: transparent; border:0px solid #ffffff">
            Показать превью: <a href="../images/no_image.gif" rel="lightbox" id="image_here_preview"><img src="../images/insertim.gif" id="image_icon_" align="top"></a>
            Показать изображение: <a href="../images/no_image.gif" rel="lightbox" id="image_here_full"><img src="../images/insertim.gif" id="image_icon_" align="top"></a>
        </td>
        <!-- Внимание: однозначное сопоставление - товар -> превьюха -> картинка. -->
    </tr>
    <tr>
        <td>Введите цену в рублях:</td>
        <td>
            Цена за упаковку:
            <input type="text" name="price_box_ru_hi" size="7" maxlenght="7" class="" value="0" tabindex="6"> рублей
            <input type="text" name="price_box_ru_lo" size="7" maxlenght="7" class="" value="0" tabindex="7"> копеек.
        </td>
    </tr>
    <!-- вставляем остальные поля -->
    <tr>
        <td>Укажите:
        </td>
        <td>
            <?php /*
          Длительность использования:&nbsp;
          <select name="dou" tabindex="8">
<?php $ref_dou = LoadReference('ref_dou');
foreach ($ref_dou as $id=>$v) echo '<option value="'.$id.'">'.$v.'</option>';

          </select> */ ?>
            Режим ношения:&nbsp;
            <select name="mow" tabindex="9">
                <?php $ref_mow = LoadReference('ref_mow');
                foreach ($ref_mow as $id=>$v) echo '<option value="'.$id.'">'.$v.'</option>';
                ?>
            </select>
            &nbsp;&nbsp;
            Цветность:&nbsp;
            <select name="chroma" tabindex="10">
                <?php $ref_chroma = LoadReference('ref_chroma');
                foreach ($ref_chroma as $id=>$v) echo '<option value="'.$id.'">'.$v.'</option>';
                ?>
            </select>
            Влагосодержание: <input type="text" name="humidity" size="4" maxlenght="4" value="0" tabindex="12"> %
            &nbsp;&nbsp;Диаметр: <input type="text" name="diameter" size="3" maxlenght="3" value="0" tabindex="13">mm
            <hr color="#BBBBBB">
            Ключевая особеность товара: <input type="text" name="feature" size="60" maxlength="60" value="">
            &nbsp;&nbsp;Линз в упаковке: <input type="text" name="lenses_in_box" size="3" maxlenght="3" value="0" tabindex="14">

        </td>
    </tr>
    <tr>
        <td colspan="2"><hr width="80%"></td>
    </tr>
    <tr>
        <td>Оптическая сила:</td>
        <td>
            <ul class="ul_list" id="list_optic">

                <?php
                $optpwrs = LoadReference("ref_opticpower");
                $i=0;
                foreach ($optpwrs as $id=>$val)
                {
                    $i++;
                    echo '
    <li class="optic"><nobr><input type="checkbox" onClick="cb(this)" name="optpwr[]" id="c'.$id.'" value="'.$id.'">'.$val.'&nbsp;&nbsp;</nobr></li>
    ';
                }
                ?>
            </ul>

        </td>
    </tr>
    <tr>
        <td>Цвета:</td>
        <td>
            <ul class="ul_list">
                <?php
                $colors = LoadReference("ref_colors");
                foreach ($colors as $id=>$val)
                {
                    echo '
    <li><nobr><input type="checkbox" name="colors[]" onClick="cb(this)" id="c'.$id.'" value="'.$id.'"> '.$val.'&nbsp;</nobr></li>
    ';
                }
                ?>
            </ul></td>
    </tr>
    <tr>
        <td>Базовая кривизна:</td>
        <td><ul class="ul_list">
            <?php
            $basecurves = LoadReference("ref_basecurve");
            foreach ($basecurves as $id=>$val)
            {
                echo '
    <li><nobr><input type="checkbox" onClick="cb(this)" name="basecurves[]" id="c'.$id.'" value="'.$id.'">'.$val.'&nbsp;</nobr></li>
    ';
            }
            ?>
        </td>
    </tr>
    <!-- астигматические линзы и очки -->
    <tr>
        <td rowspan="2">Укажите следующие <br>параметры <u>только</u> для <br>астигматических линз</td>
        <td>
            <ul class="ul_list">
                <li><b>Ось (axis):   </b></li>
                <?php
                $axis_all = LoadReference("ref_axis");
                foreach ($axis_all as $ai=>$av)
                {
//    if ($ai==1) echo '<li><nobr><input type="checkbox" name="axis[]" onClick="cb(this)" id="c'.$ai.'" value="'.$ai.'" checked> '.$av.'&nbsp;</nobr></li>'; else
                    echo '<li><nobr><input type="checkbox" name="axis[]" onClick="cb(this)" id="c'.$ai.'" value="'.$ai.'"> '.$av.'&nbsp;</nobr></li>';
                }
                ?>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
            <ul class="ul_list">
                <li><b>Цилиндр (cyl):  </b></li>
                <?php
                $cylinder_all = LoadReference("ref_cylinder");
                foreach ($cylinder_all as $yi=>$yv)
                {
//    if ($yi==1) echo '<li><nobr><input checked type="checkbox" name="cylinder[]" onClick="cb(this)" id="c'.$yi.'" value="'.$yi.'"> '.$yv.'&nbsp;</nobr></li>'; else
                    echo '<li><nobr><input type="checkbox" name="cylinder[]" onClick="cb(this)" id="c'.$yi.'" value="'.$yi.'"> '.$yv.'&nbsp;</nobr></li>';
                }
                ?>
            </ul>
        </td>
    </tr>

    <!-- краткая инфа о товаре -->
    <tr>
        <td colspan="2"><hr width="80%"></td>
    </tr>
    <tr>
        <td>Краткое описание товара:<br><small><i>Введите здесь краткое описание - оно <br>будет показываться в списке товаров.</i></small></td>
        <td>
            <div style="float:left">
                <textarea name="short_info" cols="70" rows="2" tabindex="15"></textarea>
            </div>
            <div style="float:left;margin-left:20px">
                Отметьте популярность товара<br><small>(число от -100 до 100)</small>
                <input type="text" name="popular" size="10" maxlenght="10" class="" value="0">
            </div>
        </td>
    </tr>


    <!-- редактор -->
    <tr>
        <td colspan="2">Введите полное описание товара:</td>
    </tr>
    <!-- textarea -->
    <tr>
        <td colspan="2">
            <?php
            $sw->show();
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input style="float:left;margin-left:20px" type="reset" value="Сброс">
            <input style="float:right;margin-right:20px" type="submit" value="Сохранить информацию" name="UploadGoods"/>
        </td>
    </tr>
</table>

<input type="hidden" name="TheMagicNumber" value="<?php echo $magic; ?>">
</form>
<div align="center"><input type="button" name="Return_to_market" value="Вернутся к списку товаров" onClick="document.location.href='goods.php';return false;"></div>
</body>
</html>







