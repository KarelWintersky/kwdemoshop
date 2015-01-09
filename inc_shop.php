<script>

    /* функции, которые жили в hs_order_add */
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

    /* функция синхронизации двух селектов */
    function syncSelection(it,dst)
    {
        var si = document.getElementById(it).selectedIndex;
        document.getElementById(dst).selectedIndex = si;
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

    function ajaxOrder(frm,n)
    {
        ajax=getAjax();
        var param;
        var  rnd982g  = Math.floor(Math.random()*100001);
        if (ajax != null)
        {
            ajax.open("POST",'core/order_action_insert.php',true);
            // если параметров несколько, то они разделяются &
            param="id="+n;
            param+="&rnd982g="+rnd982g;
            // количества отдельно проверяем :)
            if (document.getElementById('product_num_left_'+n))
            {
                param+="&num_left="+document.getElementById('product_num_left_'+n).value;
            }
            if (document.getElementById('product_num_right_'+n))
            {
                param+="&num_right="+document.getElementById('product_num_right_'+n).value;
            }
            if (document.getElementById('color_left_'+n))
            {
                // получим значение для... цвета
                idx_color_left = document.getElementById('color_left_'+n).selectedIndex;
                idx_color_right = document.getElementById('color_right_'+n).selectedIndex;
                param+="&color_left="+document.getElementById('color_left_'+n).options[idx_color_left].value;
                param+="&color_right="+document.getElementById('color_right_'+n).options[idx_color_right].value;
            }
            if (document.getElementById('optpower_left_'+n))
            {
                // получим значение для оптической силы
                idx_op_left = document.getElementById('optpower_left_'+n).selectedIndex;
                idx_op_right = document.getElementById('optpower_right_'+n).selectedIndex;
                param+="&op_left="+document.getElementById('optpower_left_'+n).options[idx_op_left].value;
                param+="&op_right="+document.getElementById('optpower_right_'+n).options[idx_op_right].value;
            }
            if (document.getElementById('basecurve_left_'+n))
            {
                // получим значение для базовой кривизны
                idx_bc_left = document.getElementById('basecurve_left_'+n).selectedIndex;
                idx_bc_right = document.getElementById('basecurve_right_'+n).selectedIndex;
                param+="&bc_left="+document.getElementById('basecurve_left_'+n).options[idx_bc_left].value;
                param+="&bc_right="+document.getElementById('basecurve_right_'+n).options[idx_bc_right].value;
            }
            if (document.getElementById('cylinder_left_'+n))
            {
                // получим значение для цилиндра
                idx_cylinder_left = document.getElementById('cylinder_left_'+n).selectedIndex;
                idx_cylinder_right = document.getElementById('cylinder_right_'+n).selectedIndex;
                param+="&cylinder_left="+document.getElementById('cylinder_left_'+n).options[idx_cylinder_left].value;
                param+="&cylinder_right="+document.getElementById('cylinder_right_'+n).options[idx_cylinder_right].value;
            }
            if (document.getElementById('axis_left_'+n))
            {
                // получим значение для AXIS
                idx_axis_left = document.getElementById('axis_left_'+n).selectedIndex;
                idx_axis_right = document.getElementById('axis_right_'+n).selectedIndex;
                param+="&axis_left="+document.getElementById('axis_left_'+n).options[idx_axis_left].value;
                param+="&axis_right="+document.getElementById('axis_right_'+n).options[idx_axis_right].value;
            }

            param+="&producer="+document.getElementById('producer_'+n).value;
            param+="&price_box="+document.getElementById('price_box_'+n).value;
            param+="&type="+document.getElementById('type_'+n).value;

            if (param!="")
            {
                // добавляем стандартный заголовок http посылаемый через ajax
                ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                ajax.setRequestHeader("Content-length", param.length);
                ajax.setRequestHeader("Connection", "close");

                ajax.onreadystatechange = function()
                {
                    if(ajax.readyState==4 && ajax.status==200)
                    {
                        response = ajax.responseText;
                        document.getElementById("result_"+n).innerHTML=response;
                        ajax.abort();
                    }
                }
                ajax.send(param);
            }
        }
    }
    // функция для восстановления кнопки заказа в хайслайде (hs_order_add)
    // id - айди товара (сквозная), where - куда записывать, по умолчанию - results, но вдруг поменяется.
    function close_hs(id,where,what)
    {
        hs.close(what);
        document.getElementById(where).innerHTML = '<input type="button" id="add_button_'+id+'" value="Добавить в корзину" onClick="ajaxOrder(this.form,'+id+');return false;" name="product_request">';
        return false;
    };

</script>

<div style="text-align: center;">
    <h3>Вы можете сделать заказ по телефонам: .... </h3><hr>
</div>
<table border="0" width="99%" cellpadding="2" bordercolor="red">
    <?php
    $goods_count = count($items_list);
    // $items_list - содержимое
    if (0==$goods_count) {
        ?>
        <tr><td colspan="2">В этом разделе пока нет товаров!</td></tr>
        <?php
    } else
        foreach ($items_list as $id=>$entry) {
            $colors_str = $entry["colors"];
            $colors = explode(',',$colors_str);
            $optpwr_str = $entry["opt_powers"];
            $optpwr = explode(',',$optpwr_str);
            if ($entry["feature"]!="") $entry["feature"] = $entry["feature"].', ';
            ?>
            <tr>
                <td width="130" valign="top" class="c" align="center">
                    <a href="core/image_show.php?id=<?php echo $entry["image_id"]?>" class="highslide" onclick="return hs.expand(this,{wrapperClassName: 'highslide-black-border'})">
                        <img id="small" src="core/image_preview.php?id=<?php echo $entry["preview_id"]?>" title="» увеличить «">
                        <small>» увеличить «</small>
                    </a>
                </td>
                <td class="m" style="padding-right: 20px;">
                    <h2><?php echo $entry["title"];?></h2>
                    <div>
                        <div class="s_shortinfo"><?php echo $entry["short_info"];?></div>
                        <div class="s_feature"><?php echo $entry["feature"];?>Влагосодержание:&nbsp;<?php echo $entry["humidity"];?>&nbsp;%</div>
                        <div class="s_boxsize">Упаковка <?php echo $entry["lenses_in_box"]; ?> <?php echo GetHumanFriendlyCounter($entry["lenses_in_box"],'линза','линзы','линз')?> </div>
                        <table>
                            <tr>
                                <td width="150">
                                    <h3><?php print(PrintPrice($entry["price_box"],"RU","show"));?></h3>
                                </td>
                                <td style="text-decoration: underline; color: red; font-weight: 900;">
                                    <a class="buy_request" href="core/hs_order_add.php?id=<?php echo $entry["id"]; ?>" onClick="return hs.htmlExpand(this, {objectType: 'ajax', height: 540, width: 900, wrapperClassName: 'draggable-header' })">
                                        Добавить в корзину
                                    </a>
                                </td>
                            </tr>
                        </table>
                </td>
            </tr>
            <tr><td colspan="2"><hr width="95%"></td></tr>
            <?
        }
    ?>
    <tr>
        <td colspan="2" align="right"><span style="color:navy;font-size:small">
     В данном разделе <?php echo $goods_count." ".GetHumanFriendlyCounter($goods_count,'позиция','позиции','позиций'); ?>
     </span></td>
    </tr>
</table>








