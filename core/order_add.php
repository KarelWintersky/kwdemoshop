<?php
session_start();
require_once "lib_shop.php";
global $CONFIG;
unset($entry);
$id = $_GET['id'];
$entry = LoadGoods($id);

$colors_str = $entry["colors"];
$colors = explode(',',$colors_str);

$optpwr_str = $entry["opt_powers"];
$optpwr = explode(',',$optpwr_str);

$basecurves_str = $entry["basecurves"];
$basecurves = explode(',',$basecurves_str);

$axis_str = $entry["axis"];
$axis = explode(',',$axis_str);

$cylinder_str = $cylinder["axis"];
$cylinder = explode(',',$cylinder_str);

if ($entry["feature"]!="") $entry["feature"] = $entry["feature"].'. ';
?>
<head>
    <title>Заказать <?php echo $entry["title"];?></title>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">
    <link href="order.css" rel="stylesheet" type="text/css" media="screen"/>

    <script type="text/javascript">
        function f_change_num(selection, pType, pMinNum, pStockNum)
        {
            if( selection.value.match(/[^0-9]/)){ selection.value = pMinNum; return; }
            wNum = parseInt(selection.value);
            if (pType == "0" && wNum > pMinNum) {
                selection.value = String(wNum-1);
            }
            if (pType == "1") {
                if (pStockNum) {
                    if (wNum >= pStockNum) return;
                }
                selection.value = String(wNum+1);
            }
        }
        function getAjax()
        {
            if (window.ActiveXObject) // для IE
                return new ActiveXObject("Microsoft.XMLHTTP");
            else if (window.XMLHttpRequest)
                return new XMLHttpRequest();
            else {
                alert("Browser does not support AJAX.");
                return null;
            }
        }

        function ajaxHandle(ajax)
        {
            if(ajax.readyState==4 && ajax.status==200)
            {
                var response = ajax.responseText;
                document.getElementById("result").innerHTML=response;
                document.getElementById("add_button").disabled=true;
                ajax.abort();
            }
        }


        function ajaxOrder(frm)
        {
            ajax=getAjax();
            var param;
            var  rnd982g  = Math.floor(Math.random()*100001);
            // получим значение для... цвета
            idx_color_left = document.getElementById('color_left').selectedIndex;
            idx_color_right = document.getElementById('color_right').selectedIndex;
            // получим значение для оптической силы
            idx_op_left = document.getElementById('optpower_left').selectedIndex;
            idx_op_right = document.getElementById('optpower_right').selectedIndex;

            // получим значение для базовой кривизны
            idx_bc_left = document.getElementById('basecurve_left').selectedIndex;
            idx_bc_right = document.getElementById('basecurve_right').selectedIndex;

            if (ajax != null)
            {
                ajax.open("POST",'order_action_insert.php',true);
                // если параметров несколько, то они разделяются &
                param="id=<?php echo $entry['id']; ?>";
                param+="&num_left="+document.getElementById('product_num_left').value;
                param+="&num_right="+document.getElementById('product_num_right').value;
                param+="&rnd982g="+rnd982g;
                param+="&price_box=<?php echo $entry['price_box']; ?>";
                param+="&type=<?php echo $entry['type']; ?>";
                param+="&color_left="+document.getElementById('color_left').options[idx_color_left].value;
                param+="&color_right="+document.getElementById('color_right').options[idx_color_right].value;
                param+="&op_left="+document.getElementById('optpower_left').options[idx_op_left].value;
                param+="&op_right="+document.getElementById('optpower_right').options[idx_op_right].value;
                param+="&bc_left="+document.getElementById('basecurve_left').options[idx_bc_left].value;
                param+="&bc_right="+document.getElementById('basecurve_right').options[idx_bc_right].value;
                param+="&producer=<?php echo $entry['producer']; ?>";

                //    alert(param);
                if (param!="") {
                    // добавляем стандартный заголовок http посылаемый через ajax
                    ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    ajax.setRequestHeader("Content-length", param.length);
                    ajax.setRequestHeader("Connection", "close");

                    ajax.onreadystatechange = function()
                    {
                        if(ajax.readyState==4 && ajax.status==200)
                        {
                            response = ajax.responseText;
                            document.getElementById("result").innerHTML=response;
                            document.getElementById("add_button").disabled=true;
                            ajax.abort();
                        }
                    }
                    // посылаем наши данные или пустую строку (param="") главное не null
                    ajax.send(param);
                }
            }
        }

        /* функция синхронизации двух селектов */
        function syncSelection(it,dst)
        {
            var si = document.getElementById(it).selectedIndex;
            document.getElementById(dst).selectedIndex = si;
        }
    </script>
</head>

<body>
<form name="product_form">
    <table width="100%">
        <tr>
            <td colspan="3">
                <div class="product_title"><?php echo $entry["title"];?></div>
            </td>
            <td align="right">
                <input type="button" name="Return_to_market" value="X" src="../images/exit.png" onClick="window.close(self);return false;">
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top" align="center">
                <a href="image_show.php?id=<?php echo $entry["image_id"]?>" rel="lightbox">
                    <img border="1" id="preview" src="image_show.php?id=<?php echo $entry["preview_id"]?>"/>
                </a>
            </td>
            <td colspan="3">
                <div class="char">Режим ношения: <?php echo GetRefData('ref_mow',$entry["mow"]); ?></div>
                <div class="char">Диаметр: <?php echo $entry["diameter"];?> мм.</div>
                <div class="char"><?php echo $entry["feature"];?>Влагосодержание:&nbsp;<?php echo $entry["humidity"];?>&nbsp;%</div>
                <div class="char">Упаковка <?php echo $entry["lenses_in_box"]; ?> <?php echo GetHumanFriendlyCounter($entry["lenses_in_box"],'линза','линзы','линз')?></div>
                <div class="char">Цена за упаковку:&nbsp;<?php print(PrintPrice($entry["price_box"],"RU","show"));?></div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="product_text"><?php echo $entry["description"];?></div></td>
        </tr>
        <tr>
            <td colspan="4">
                <hr>
            </td>
        </tr>
        <tr>
            <td width="30%">
            </td>
            <td width="20%" height="30px">
                Левый
            </td>
            <td colspan="2">
                Правый
            </td>
        </tr>
        <tr>
            <td width="30%">
                <span style="padding-left: 20px;">Радиус кривизны</span>
            </td>
            <td width="20%">
                <select id="basecurve_left" onChange="syncSelection('basecurve_left','basecurve_right')">
                    <?php $ref_basecurves = LoadReference('ref_basecurve');
                    foreach ($basecurves as $v) echo '<option value="'.$v.'">'.$ref_basecurves[$v].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="basecurve_right">
                    <?php $ref_basecurves = LoadReference('ref_basecurve');
                    foreach ($basecurves as $v) echo '<option value="'.$v.'">'.$ref_basecurves[$v].'</option>';
                    ?></select>
            </td>
        </tr>
        <tr>
            <td width="30%">
                <span style="padding-left: 20px;">Оптическая сила</span>
            </td>
            <td width="20%">
                <select id="optpower_left" onChange="syncSelection('optpower_left','optpower_right')">
                    <?php $ref_op = LoadReference('ref_opticpower');
                    foreach ($optpwr as $v) echo '<option value="'.$v.'">'.$ref_op[$v].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="optpower_right">
                    <?php $ref_op = LoadReference('ref_opticpower');
                    foreach ($optpwr as $v) echo '<option value="'.$v.'">'.$ref_op[$v].'</option>';
                    ?></select>
            </td>
        </tr>
        <tr>
            <td width="30%">
                <span style="padding-left: 20px;">Цвет</span>
            </td>
            <td width="20%">
                <select id="color_left" onChange="syncSelection('color_left','color_right')">
                    <?php $ref_colors = LoadReference('ref_colors');
                    foreach ($colors as $v) echo '<option value="'.$v.'">'.$ref_colors[$v].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="color_right">
                    <?php $ref_colors = LoadReference('ref_colors');
                    foreach ($colors as $v) echo '<option value="'.$v.'">'.$ref_colors[$v].'</option>';
                    ?></select>
            </td>
        </tr>
        <tr>
            <td width="30%">
                <span style="padding-left: 20px;">Количество</span>
            </td>
            <td width="20%">
                <table border="0" style="margin-left: -3px;"><tr>
                    <td><input type="text" id="product_num_left" name="product_num_left" value="1" style="width: 58px;" /></td>
                    <td>
                        <div style="width: 15px; margin: 0px;">
                            <a href="javascript:f_change_num(document.product_form.product_num_left,'1',0,null);"><img border="0" src="../images/nup.gif"></a>
                            <a href="javascript:f_change_num(document.product_form.product_num_left,'0',0,null);"><img border="0" src="../images/ndown.gif"></a>
                        </div>
                    </td>
                </tr></table>
            </td>
            <td colspan="2">
                <table border="0" style="margin-left: -3px;"><tr>
                    <td><input type="text" id="product_num_right" name="product_num_right" value="0" style="width: 58px;" /></td>
                    <td>
                        <div style="width: 15px; margin: 0px;">
                            <a href="javascript:f_change_num(document.product_form.product_num_right,'1',0,null);"><img border="0" src="../images/nup.gif"></a>
                            <a href="javascript:f_change_num(document.product_form.product_num_right,'0',0,null);"><img border="0" src="../images/ndown.gif"></a>
                        </div>
                    </td>
                </tr></table>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="right">
                <input type="button" id="add_button" value="Добавить в корзину" onClick="ajaxOrder(this.form);return false;" name="product_request">
            </td>
        </tr>

    </table>
    <div id="result">
    </div>
    <input type="hidden" name="product_id" value="<?php echo $entry["id"]; ?>">
</form>

</body>

