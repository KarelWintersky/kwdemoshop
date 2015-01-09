<?php
require_once "core/lib_core.php";
setlocale(LC_ALL,"ru_RU.CP1251");
?>
<script>

    function getAjax(){
        if (window.ActiveXObject)
            return new ActiveXObject("Microsoft.XMLHTTP");
        else if (window.XMLHttpRequest)
            return new XMLHttpRequest();
        else {
            alert("Browser does not support AJAX.");
            return null;
        }
    }
    function ajaxFunction(frm,file){
        ajax=getAjax();
        var param;
        var  rnd982g  =  randomnumber=Math.floor(Math.random()*101)
        if (ajax != null) {
            ajax.open("POST",file,true);
            param="FAQ_Question="+encodeURIComponent(document.getElementById('FAQ_Question').value);
            param+="&FAQ_user_name="+document.getElementById('FAQ_user_name').value;
            param+="&rnd982g="+rnd982g;

            ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            ajax.setRequestHeader("Content-length", param.length);
            ajax.setRequestHeader("Connection", "close");
            ajax.onreadystatechange = function(){
                if(ajax.readyState==4 && ajax.status==200)
                {
                    response = ajax.responseText;
                    document.getElementById("results").innerHTML=response;
                }
            }
            ajax.send(param);
        }
    }
</script>

<div style="text-decoration: underline; color: red; font-weight: 900; font-size: 18px;">
    <a class="faq_request" href="core/hs_faq_new_question.php" onClick="return hs.htmlExpand(this, {objectType: 'ajax', width: 407, height: 225, wrapperClassName: 'draggable-header'} );window.open('core/faq_new_question.php','','scrollbars=0,width=390,height=220,top=160,left=60');return false;">Задать свой вопрос</a>
</div>
<br><br>

<table width="714px" class="faq_list" border="0">
    <?php
    if (0==count($items_list))
    {
        ?>
        <tr><td colspan="2" align="left">Пока никто не попросил консультацию.</td></tr>
        <?php
    }
    else
        foreach ($items_list as $id=>$item)
        {
            if (strlen($item["answer"])<2) { $no_answer=1; $item["answer"] = "Ответа пока нет"; }
            else $no_answer=0;
            ?>
            <tr>
                <td>Спрашивает: </td>
                <td>
                    <div style="float:left"><span class="icon_user"> <?php echo $item["user_name"]; ?></div>
                    <span style="float:right;"><?php echo PrintDate($item["time_create"]); ?></span>
                </td>
            </tr>
            <tr>
                <td width="120px"><span class="icon_queston">Вопрос:</span></td>
                <td><?php echo stripslashes($item["question"]); ?></td>
            </tr>
            <tr>

                <?php
                if ($no_answer) {
                    ?>
                    <td colspan="2"><span class="icon_answer"><?php echo stripslashes($item["answer"]); ?></span></td>
                    <?php } else { ?>
                    <td><span class="icon_answer">Ответ:</td>
                    <td><span class="the_answer"><?php echo stripslashes($item["answer"]); ?></span></td>
                    <? } ?>
            </tr>
            <tr><td colspan="2"><hr></td></tr>
            <?php
        }
    ?>
</table>
