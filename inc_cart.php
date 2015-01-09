<?php
session_start();
$root = ($_SERVER['REMOTE_ADDR']==="127.0.0.1") ? "" : $_SERVER['DOCUMENT_ROOT'];

$sum_price    = IsSet($_SESSION['cart_sumprice']) ? $_SESSION['cart_sumprice'] : 0;
$orders_num   = IsSet($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$the_user     = (IsSet($_SESSION['userinfo'])) ? $_SESSION['userinfo'] : array ();
$fullname     = ($_SESSION['is_logged']) ? $the_user['surname']." ".$the_user['name']." ".$the_user['patro'] : "";
$username     = $the_user;
// загрузим справочники
$ref_basecurves = LoadReference('ref_basecurve');
$ref_colors = LoadReference('ref_colors');
$ref_opticpowers = LoadReference('ref_opticpower');
?>
<script>
function RefreshAndClose(it)
{
    window.opener.Refresh();
    window.close(it);
}

function RefreshHS(it)
{
    window.opener.refresh(it);
    hs.close(this);
}

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

function makeRequest(url,control) {
    var httpRequest = false;

    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) {
            httpRequest.overrideMimeType('text/xml');
        }
    } else if (window.ActiveXObject) { // IE
        try {
            httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }

    if (!httpRequest) {
        alert('Не вышло :( Невозможно создать экземпляр класса XMLHTTP ');
        return false;
    }
    httpRequest.onreadystatechange = function() { alertContents(httpRequest,control); };
    httpRequest.open('GET', url, true);
    httpRequest.send(null);
}

function alertContents(httpRequest,control) {

    if (httpRequest.readyState == 4) {
        if (httpRequest.status == 200) {
            control.innerHTML = httpRequest.responseText;
        } else {
            alert('С запросом возникла проблема.'+httpRequest.url);
        }
    }

}

function cart_confirm_purge(id,targ,cost_targ) {
    vid = 1+id;
    if (confirm('Вы уверены, что хотите удалить заказ номер '+vid+' из корзины?'))
    {
        req = 'core/order_action_purge.php?id='+id;
        makeRequest(req,document.getElementById(targ));
        req = 'core/order_action_getcartcost.php';
        makeRequest(req,document.getElementById(cost_targ));
        return false;
    }
}

/* функции, которые жили в hs_order_edit */

function getAjax()
{
    if (window.ActiveXObject)
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
    if (ajax != null)
    {
        ajax.open("POST",'core/order_action_update.php',true);
        param="cart_pos="+document.getElementById('cart_pos_'+n).value;        // позиция товара в корзине

        param+="&rnd982g="+Math.floor(Math.random()*100001);
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
        //
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
        param+="&id="+document.getElementById('product_id_'+n).value;

        if (param!="")
        {
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

// функция восстановления кнопки заказа в хайслайде (hs_order_add)
// id - айди товара (сквозная), where - куда записывать, по умолчанию - results, но вдруго поменяется.
function close_hs(id,where,what)
{
    hs.close(what);
    window.location.reload(what);
    return false;
};


</script>

<?php

if (0===$orders_num) {
    ?>
<h2>Корзина пуста!</h2>
<span align="center"><a href="?action=shop">Перейти к магазину</a></span>
<?php
} else
    foreach ($_SESSION['cart'] as $index=>$record)
    {
        unset($product_info);
        $product_info = LoadGoods($record['id']);
        ?>


    <table class="hr" width="95%">
        <tr>
            <td>
    <span id="cart_record_<?php echo $index ?>">
      <table width="100%" border="0" class="cart_record">
          <!-- 1 -->
          <tr>
              <td width="*" colspan="3">
                  <a href="core/hs_order_edit.php?id=<?php echo $index; ?>"
                     onClick="return hs.htmlExpand(this, {objectType: 'ajax', height: 540, width: 900, wrapperClassName: 'draggable-header'});window.open('core/order_add.php?id=<?php echo $record["id"];?>','','scrollbars=1,width=600,height=650,top=140,left=60');return false;">
                      <strong><?php echo GetRefData('ref_producer',$product_info['producer']); ?>, </strong><?php echo $product_info["title"]; ?></a>
                  </a>
              </td>
              <td colspan="2" align="right">
                  <a class="del_cart_item" href="javascript://" onClick="return cart_confirm_purge(<?php echo $index ?>,'cart_record_<?php echo $index ?>','full_cart_cost')" id="cart_record_del_<?php echo $index ?>">
                      <span style="font-weight: 600; font-size: x-small; vertical-align: top;">УДАЛИТЬ<span><img style="vertical-align: bottom;"src="images/tx2.png" height="28" width="28" border="0" alt="Удалить"></a>
              </td>
          </tr>
          <!-- right -->
          <tr>
              <td align="left" width="65"><small>ПРАВЫЙ:</small></td>
              <td align="center" width="130"><small><?php echo "Кривизна: <b>".$ref_basecurves[$record["bc_right"]]."</b>"; ?></small></td>
              <td align="center" width="130"><small><?php echo "Диоптрии: <b>".$ref_opticpowers[$record["op_right"]]."</b>"; ?></small></td>
              <td align="center"><small><?php echo "<b>".$record["num_right"]."</b> уп.";?><?php echo " ( ".$product_info["lenses_in_box"]." шт.) ".$ref_colors[$record["color_right"]];?></small></td>
              <td align="right" width="80"><small><!-- --><?php echo PrintPrice($record["num_right"]*$product_info["price_box"],"RU","show") ;?><!-- --></small></td>
          </tr>
          <!-- left -->
          <tr>
              <td align="left"><small>ЛЕВЫЙ:</small></td>
              <td align="center" width="130"><small><?php echo "Кривизна: <b>".$ref_basecurves[$record["bc_left"]]."</b>"; ?></small></td>
              <td align="center" width="130"><small><?php echo "Диоптрии: <b>".$ref_opticpowers[$record["op_left"]]."</b>"; ?></small></td>
              <td align="center"><small><?php echo "<b>".$record["num_left"]."</b> уп.";?><?php echo " ( ".$product_info["lenses_in_box"]." шт.) ".$ref_colors[$record["color_left"]];?></small></td>
              <td align="right" width="80"><small><?php echo PrintPrice($record["num_left"]*$product_info["price_box"],"RU","show");?></small></td>
          </tr>
          <?php /*        <tr>
          <td width="55" align="left"><small>Итого:</small></td>
          <td align="left"><small>&nbsp;</small></td>
          <td align="center"><small><?php //echo $record['num_this']." уп.";?></small></td>
          <td align="right" width="100"><small>&nbsp;<?php echo PrintPrice($record["num_right"]*$product_info["price_box"]+$record["num_left"]*$product_info["price_box"],"RU","show");?></small></small></td>
          <td align="center"><small></td>
        </tr> */ ?>
      </table>
    </span>
            </td>
        </tr>
    </table>

    <?php
    }
?>

</table>
<br>
<script>
    function ShowForm(id,thistrg,vismsg,hidmsg)
    {
        thistrg.innerHTML = (document.getElementById(id).style.display == '') ? vismsg : hidmsg;
        document.getElementById(id).style.display=(document.getElementById(id).style.display == 'none' ) ? '' : 'none';
    }
</script>

<?php if ($orders_num) { ?>

<table width="95%">
    <tr>
        <td>
            <?php
            $sum_price = CalcCartCost();
            $str_price = PrintPrice($sum_price,"RU","show");
            ?>
            Общая стоимость: <span id="full_cart_cost" style="color:red; font-weight: 600;"><?php print($str_price); ?></span>
        </td>
        <td align="right" style="color:red; text-decoration: underline; font-weight:bold">
            <a class="order_fill" href="javascript://" onClick="ShowForm('confirmform',this,'Оформить заказ','Скрыть форму заказа')">Оформить заказ</a></span>
        </td>
</table>

<div style="padding-right: 28px; text-align:right;"><br>Вы также могли сделать заказ по телефонам:<br><span style="font-size: medium; color:red;">....</span></div>
<br>
<div id="confirmform" style="display:none; border: 2px solid #555555; padding: 10px; width: 516px; line-" class="no_table">
    <form action="sender.php" method="post">

        <table width="516">
            <tr>
                <td colspan="3"><span style="float:left;">Контактные данные: </span><input style="float:right;" id="cont_FIO" type="text" title="required" name="fio" value="<?php echo $_SESSION["userinfo"]["fullname"]; ?>" /></td>
            </tr>
            <tr>
                <td>Телефон:</td>
                <td><input id="cont_phone" type="text" name="phone" title="required" value="<?php echo $username['phone'] ?>" /></td>
                <td align="right">E-Mail: <input id="cont_email" type="text" title="required" name="email" size="25"  value="<?php echo $username['email'] ?>" /></td>
            </tr>
            <tr>
                <td valign="top">Адрес доставки:</td>
                <td colspan="2"><textarea id="cont_adress" name="delivery_addr" title="required" rows="3"><?php echo $username['delivery_addr'] ?></textarea></td>
            </tr>
        </table>

        <br>
        <?php if (!$_SESSION['is_logged']) { ?>
        <input style="float:left" type="button" value="Зарегистрироваться" name="register_button" onClick="document.location.href='?action=register&return=cart';return false;">
        <?php } ?>
        <input style="float:right; font-weight: 600;" type="submit" value="Купить!" name="send_button">
        <input type="hidden" name="u_name" value="<?php echo $username['username']?>">

    </form>
</div>
<?php } ?>


