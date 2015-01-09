<?php
session_start();
?>
<html>
<head>
    <script>

        // закрывает себя и обновляет родителя
        function RefreshAndClose(it)
        {
            opener.location.reload();
            window.close();
        }

        function getAjax(){
            if (window.ActiveXObject) // для IE
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
                // метод POST, указываем просто имя файла
                ajax.open("POST",file,true);

                param="FAQ_Question="+encodeURIComponent(document.getElementById('FAQ_Question').value);
                param+="&FAQ_user_name="+encodeURIComponent(document.getElementById('FAQ_user_name').value);
                param+="&rnd982g="+rnd982g;

                ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                ajax.setRequestHeader("Content-length", param.length);
                ajax.setRequestHeader("Connection", "close");
                ajax.onreadystatechange = function(){
                    if(ajax.readyState==4 && ajax.status==200)
                    {
                        prompt('Sent: ',param);
                        response = ajax.responseText;
                        document.getElementById("results").innerHTML=response;
                        document.getElementById("quest_button").disabled=true;
                    }
                }
                ajax.send(param);
            }
        }

    </script>
</head>
<body>
<form>
    <input type="hidden" name="FAQ_user_id" value="<?php echo $_SESSION["userinfo"]["id"];?>">
    <input type="hidden" name="FAQ_caller" value="user">

    <table border="0">
        <tr>
            <td align="right">
                Ваше имя:
            </td>
            <td>
                <input style="width: 270px; height: 20px; padding-left: 3px; margin-bottom: 6px;" type="text" name="FAQ_user_name" id="FAQ_user_name" value="<?php echo $_SESSION["userinfo"]["fullname"];?>"></textarea><br>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">
                Введите&nbsp; вопрос:
            </td>
            <td>
                <textarea style="width: 270px; padding-left: 3px;" title="required" name="FAQ_Question" id="FAQ_Question" cols="30" rows="5" value=""></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="button" id="quest_button" value="Задать вопрос"  onClick="ajaxFunction(this.form,'faq_action_insert_ajax.php');return false;">
            </td>
        </tr>
    </table>
    <!-- Вызывать аякс в ->result -->
</form>
<div id="results">
    <input type="button" name="return" value="Закрыть окно" onClick="window.close();">
</div>
<br>
</body>
</html>

