<?php
session_start();
require_once "lib_shop.php";
unset($entry);

$cart = $_SESSION['cart'];
$cart_pos = $_GET['id'];   // позиция (номер записи) в корзине
$entry = $cart[$cart_pos];  // полная запись о товаре из корзинки

$product = LoadGoods($entry["id"]); // информация о товаре из БД

// это мы развернем сериализованные строки в массивы
$colors_str = $product["colors"];
$colors = explode(',',$colors_str);
$optpwr_str = $product["opt_powers"];
$optpwr = explode(',',$optpwr_str);
$basecurve_str = $product["basecurves"];
$basecurve = explode(',',$basecurve_str);

$ref_basecurve = LoadReference('ref_basecurve');
$ref_op = LoadReference('ref_opticpower');
$ref_colors = LoadReference('ref_colors');

if ($product["feature"]!="") $product["feature"] = $product["feature"].'. ';

?>
<head>
    <title>Редактировать <?php echo $product["title"];?></title>
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
                ajax.open("POST",'order_action_update.php',true);
                // если параметров несколько, то они разделяются &
                param="cart_pos=<?php echo $cart_pos; ?>";        // позиция товара в корзине
                param+="&num_left="+document.getElementById('product_num_left').value;
                param+="&num_right="+document.getElementById('product_num_right').value;
                param+="&rnd982g="+rnd982g;
                param+="&price_box=<?php echo $product['price_box']; ?>";
                param+="&type=<?php echo $product['type']; ?>";
                param+="&color_left="+document.getElementById('color_left').options[idx_color_left].value;
                param+="&color_right="+document.getElementById('color_right').options[idx_color_right].value;
                param+="&op_left="+document.getElementById('optpower_left').options[idx_op_left].value;
                param+="&op_right="+document.getElementById('optpower_right').options[idx_op_right].value;
                param+="&bc_left="+document.getElementById('basecurve_left').options[idx_bc_left].value;
                param+="&bc_right="+document.getElementById('basecurve_right').options[idx_bc_right].value;
                param+="&producer=<?php echo $product['producer']; ?>";
                param+="&id=<?php echo $product['id']; ?>"        // айди товара

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
                            // обновление даннных в окне родителя!
                            ajax.abort();
                            /*              ajax.open("GET",'order_action_getcartcost.php',true);
                                          ajax.onreadystatechange = function ()
                                            { if (ajax.readyState==4 && ajax.status==200)
                                              {
                                                var result = ajax.responseText;
                                                window.opener.document.full_cart_cost.value=result;
                                              }
                                            }
                                          ajax.send(null);
                                          ajax.abort;      */
                        }
                    }
                    // посылаем наши данные или пустую строку (param="") главное не null
                    ajax.send(param);
                }
            }
        }

        function ajaxHandle()
        {
            if (ajax.readyState == 4)
            {
                if (ajax.status == 200)
                {
                    var responce = ajax.responceText;
                    document.getElementById("result").innerHTML=response;
                    document.getElementById("add_button").disabled=true;
                    ajax.abort();
                } else document.getElementById("result").innerHTML  = ajax.status+" - "+ajax.statusText;
            }
        }
        // закрывает себя и обновляет родителя
        function RefreshAndClose(it)
        {
            opener.location.reload();
            window.close();
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
                <div class="product_title"><?php echo $product["title"];?></div>
            </td>
            <td width="30%" align="right">
                <input type="button" name="Return_to_market" value="Закрыть окно"  src="../images/exit.png" onClick="window.close(self);return false;">
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top" align="center">
                <a href="image_show.php?id=<?php echo $product["image_id"]?>" rel="lightbox">
                    <img border="1" id="preview" src="image_show.php?id=<?php echo $product["preview_id"]?>"/>
                </a>
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
                <div class="product_text"><?php echo $product["description"];?></div></td>
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
                    <?php
                    foreach ($basecurve as $vl)
                        if ($vl!=$entry['bc_left']) echo '<option value="'.$vl.'">'.$ref_basecurve[$vl].'</option>';
                        else echo '<option value="'.$vl.'" selected>'.$ref_basecurve[$vl].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="basecurve_right">
                    <?php
                    foreach ($basecurve as $vr)
                        if ($vr!=$entry['bc_right']) echo '<option value="'.$vr.'">'.$ref_basecurve[$vr].'</option>';
                        else echo '<option value="'.$vr.'" selected>'.$ref_basecurve[$vr].'</option>';
                    ?></select>
            </td>
        </tr>
        <tr>
            <td width="30%">
                <span style="padding-left: 20px;">Оптическая сила</span>
            </td>
            <td width="20%">
                <select id="optpower_left" onChange="syncSelection('optpower_left','optpower_right')">
                    <?php
                    foreach ($optpwr as $v)
                        if ($v!=$entry['op_left']) echo '<option value="'.$v.'">'.$ref_op[$v].'</option>';
                        else echo '<option value="'.$v.'" selected>'.$ref_op[$v].'</option>';
                    ?></select>
            </td>
            <td colspan="2">
                <select id="optpower_right">
                    <?php
                    foreach ($optpwr as $v)
                        if ($v!=$entry['op_right']) echo '<option value="'.$v.'">'.$ref_op[$v].'</option>';
                        else echo '<option value="'.$v.'" selected>'.$ref_op[$v].'</option>';
                    ?></select>
            </td>
        </tr>
        <tr>
            <td width="30%">
                <span style="padding-left: 20px;">Цвет</span>
            </td>
            <td width="20%">
                <select id="color_left" onChange="syncSelection('color_left','color_right')">
                    <?php
                    foreach ($colors as $v)
                        if ($v!=$entry['color_left']) echo '<option value="'.$v.'">'.$ref_colors[$v].'</option>';
                        else echo '<option value="'.$v.'" selected>'.$ref_colors[$v].'</option>';

                    ?></select>
            </td>
            <td colspan="2">
                <select id="color_right">
                    <?php
                    foreach ($colors as $v)
                        if ($v!=$entry['color_right']) echo '<option value="'.$v.'">'.$ref_colors[$v].'</option>';
                        else echo '<option value="'.$v.'" selected>'.$ref_colors[$v].'</option>';
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="30%">
                <span style="padding-left: 20px;">Количество</span>
            </td>
            <td width="20%">
                <table border="0" style="margin-left: -3px;"><tr>
                    <td><input type="text" id="product_num_left" name="product_num_left" value="<?php echo $entry['num_left']?>" style="width: 58px;" /></td>
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
                    <td><input type="text" id="product_num_right" name="product_num_right" value="<?php echo $entry['num_right']?>" style="width: 58px;" /></td>
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
            <td width="30%">
            </td>
            <td width="20%">
            </td>
            <td width="20%">
            </td>
            <td width="25%" align="right">
                <input type="button" id="add_button" value="Сохранить" onClick="ajaxOrder(this.form);return false;" name="product_request">
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div id="result" align="right"></div>
            </td>
        </tr>
    </table>
    <input type="hidden" name="cart_pos" value="<?php echo $cart_pos; ?>">
</form>
<div id="result">
</div>

</body>


