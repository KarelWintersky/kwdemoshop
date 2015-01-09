<?php
// перегрузим данные о пользователе из БД
// возможно они изменились!
session_start();
require_once "lib_core.php";

if (IsSet($_GET["id"]))
{
    // вызвали с id=... т.е. из админки
    $userinfo = LoadUserInfo($_GET["id"]);
    $script = 'profile_control_update.php';
} else
{
    // вызвали без id, т.е. инклюдом из индекса
    $id = $_SESSION['userinfo']['id'];
    unset($userinfo);
    $userinfo = ReloadUserinfo($id);
    $script = 'core/profile_control_update.php';
}
/*   $id = $userinfo['id'];
  unset($userinfo);
  $userinfo = ReloadUserinfo($id); */
?>
<?php if (IsSet($_GET["id"])) { ?>
<style>
    .pe_correct {
        color: navy;
        float: left;
    }
    .pe_error {
        color: red;
        float: left;
    }
    .pe_button {
        float: right;
    }
</style>
<?php } ?>
<script>
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

    function ajaxUpdateProfile(frm,file)
    {
        ajax=getAjax();
        var param;
        var  rnd982g  =  randomnumber=Math.floor(Math.random()*101)
        if (ajax != null)
        {
            ajax.open("POST",file,true);
            param="surname="+encodeURIComponent(document.getElementById('surname').value);
            param+="&name="+encodeURIComponent(document.getElementById('name').value);
            param+="&patro="+encodeURIComponent(document.getElementById('patro').value);
            param+="&phone="+encodeURIComponent(document.getElementById('phone').value);
            param+="&email="+encodeURIComponent(document.getElementById('email').value);
            param+="&delivery_addr="+encodeURIComponent(document.getElementById('delivery_addr').value);
            param+="&newpassword="+document.getElementById('newpassword').value;
            param+="&password="+document.getElementById('password').value;
            param+="&username=<?php echo $userinfo['username']?>";
            param+="&id=<?php echo $userinfo['id']?>";
            param+="&is_subscriber="+document.getElementById('is_subscriber').value;

            ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            ajax.setRequestHeader("Content-length", param.length);
            ajax.setRequestHeader("Connection", "close");
            ajax.onreadystatechange = function(){
                if(ajax.readyState==4 && ajax.status==200)
                {
                    response = ajax.responseText;
                    document.getElementById("result").innerHTML=response;
                }
            }
            ajax.send(param);
        }
    }

    function cb(span)
    {
        span.parentNode.style["fontWeight"] = span.checked ? "bold" : "";
    }
</script>
<?php if (!IsSet($_GET["id"])) echo "<br><br><br>";?>
<form>
    <table border="0" width="80%">
        <?php if (IsSet($_GET["id"])) {?>
        <tr>
            <td align="right">
                <input type="button" name="Return_to_market" value="X" onClick="window.close(self);return false;">
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td>Ваш идентификатор</td><td><input type="text" id="username" value="<?php echo $userinfo["username"]?>" readonly/></td>
        </tr>
        <tr>
            <td>Фамилия</td><td><input type="text" id="surname" size="60" value="<?php echo $userinfo["surname"]?>"/></td>
        </tr>
        <tr>
            <td>Имя:</td><td><input type="text" id="name" value="<?php echo $userinfo["name"]?>"/></td>
        </tr>
        <tr>
            <td>Отчество:</td><td><input type="text" id="patro" size="60" value="<?php echo $userinfo["patro"]?>"/></td>
        </tr>
        <tr>
            <td>Телефон:</td><td><input type="text" id="phone" size="25" value="<?php echo $userinfo["phone"]?>"/></td>
        </tr>
        <tr>
            <td>E-Mail:</td>
            <td>
                <input type="text" id="email" size="25" value="<?php echo $userinfo["email"]?>"/>
                <span><input type="checkbox" id="is_subscriber" value="1" onClick="cb(this)" <?php if ($userinfo["is_subscriber"]) echo "checked";?> /> «« Получать нашу рассылку</span>
            </td>
        </tr>
        <tr>
            <td>Адрес доставки:</td>
            <td>
                <textarea id="delivery_addr" cols="50" rows="4"><?php echo $userinfo["delivery_addr"]?></textarea>
            </td>
        </tr>
        <tr><td colspan="2" class="c">Для изменения информации укажите текущий пароль</td></tr>
        <tr>
            <td><span class="red">Текущий пароль:</span></td><td><input type="password" id="password" /></td>
        </tr>
        <tr>
            <td>Новый пароль:</td><td><input type="text" id="newpassword" /><br><span class="alert"><span class="red">Внимание!</span> Новый пароль вводится "в открытую"</span></td>
        </tr>
        <tr>
            <td colspan="2">
                <div id="result">
                    <input type="button" id="submit_button" value="Изменить данные" src="../images/submit_order.png"/
                    onClick="ajaxUpdateProfile(this.form,'<?php echo $script ?>');return false;">
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            </td>
        </tr>
    </table>
</form>


