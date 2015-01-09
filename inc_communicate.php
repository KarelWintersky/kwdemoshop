<?php
?>
<script>

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

    function ajaxCommSend(frm,file)
    {
        ajax=getAjax();
        var param;
        var  rnd982g  =  randomnumber=Math.floor(Math.random()*101)
        if (ajax != null)
        {
            ajax.open("POST",file,true);
            param="comm_from="+encodeURIComponent(document.getElementById('comm_from').value);
            param+="&comm_subj="+encodeURIComponent(document.getElementById('comm_subj').value);
            param+="&comm_msg="+encodeURIComponent(document.getElementById('comm_msg').value);
            param+="&comm_email="+encodeURIComponent(document.getElementById('comm_email').value);
            param+="&reload=this";

            ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            ajax.setRequestHeader("Content-length", param.length);
            ajax.setRequestHeader("Connection", "close");
            ajax.onreadystatechange = function(){
                if(ajax.readyState==4 && ajax.status==200)
                {
                    response = ajax.responseText;
                    document.getElementById("comm_result").innerHTML=response;
                    document.getElementById("comm_button").disabled=true;
                }
            }
            ajax.send(param);
        }
    }

    function  handleResponse()
    {
        if(x_request.readyState  ==  4)
        {
            if (x_request.status == 200)
            {
                var  response  =  x_request.responseText;
                document.getElementById("results").innerHTML  =  response;
                x_request.abort();
            } else document.getElementById("results").innerHTML  = x_request.status+" - "+x_request.statusText;
        }
    }

    // @tag: LIB
    function ClearInner(id)
    {
        id.innerHTML='';
    }
    function ClearVal(id)
    {
        id.value='';
    }
</script>
<br><br><br>
<form>
    <table border="0" width="80%">
        <tr>
            <td colspan="2" align="center">Связь с менеджером</td>
        </tr>
        <tr>
            <td width="15%">Кому: </td><td><?php echo $CONFIG['manager_email']; ?> </td>
        </tr>
        <tr>
            <td>Ваше имя: </td>
            <td>
                <input type="text" size="60" id="comm_from" value="<?php echo $_SESSION['userinfo']['fullname']; ?>">
            </td>
        </tr>
        <tr>
            <td>Тема: </td>
            <td><input type="text" size="60" id="comm_subj" onFocus="ClearVal(this)" value="Тема"></td>
        </tr>
        <tr valign="top">
            <td>Текст сообщения: </td>
            <td><textarea name="comm_msg" cols="60" rows="10" id="comm_msg" onFocus="this.innerHTML=''">Введите здесь сообщение</textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input style="float:left" type="button" id="comm_button" name="comm_submit" value="Послать сообщение"
                       onClick="ajaxCommSend(this.form,'core/comm_action_send.php');return false;" tabindex="" />
                <input style="float:right" type="reset" value="Очистить форму"/>
            </td>
        </tr>
        <tr>
            <td>Статус отправки:</td>
            <td><div id="comm_result">Сообщение не отправлялось</div></td>
        </tr>
        <input type="hidden" id="comm_email" value="<?php echo $userinfo['email']; ?>">
    </table>
</form>
