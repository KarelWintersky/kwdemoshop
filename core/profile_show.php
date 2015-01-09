<?php
session_start();


require_once "lib_core.php";
$id = IsSet($_GET['id']) ? $_GET['id'] : 1;
$info = LoadUserInfo($id);
?>

<form>
    <table border="0" width="80%">
        <tr>
            <td width="180">Ваш идентификатор</td><td><input type="text" id="username" value="<?php echo $info["username"]?>" readonly/></td>
        </tr>
        <tr>
            <td>Фамилия</td><td><input type="text" id="surname" size="60" value="<?php echo $info["surname"]?>"/></td>
        </tr>
        <tr>
            <td>Имя:</td><td><input type="text" id="name" value="<?php echo $info["name"]?>"/></td>
        </tr>
        <tr>
            <td>Отчество:</td><td><input type="text" id="patro" size="60" value="<?php echo $info["patro"]?>"/></td>
        </tr>
        <tr>
            <td>Телефон:</td><td><input type="text" id="phone" size="25" value="<?php echo $info["phone"]?>"/></td>
        </tr>
        <tr>
            <td>E-Mail:</td><td><input type="text" id="email" size="25" value="<?php echo $info["email"]?>"/></td>
        </tr>
        <tr>
            <td>На рассылку подписан:</td>
            <td><?php
                if ($info["is_subscriber"]) echo "ДА"; else echo "НЕТ"; ?></td>
        </tr>
        <tr><td colspan="2"><hr width="80%"></td></tr>
        <tr>
            <td>Адрес доставки:</td>
            <td>
                <textarea id="delivery_addr" cols="50" rows="4"><?php echo $info["delivery_addr"]?></textarea>
            </td>
        </tr>
        <tr>
            <td>Уровень доступа:</td><td><input size="8" type="text" id="text" value="<?php echo $info["usergroup"]?>" />
            <span class="red">MD5-хэш:</span><input size="36" type="text" id="password" value="<?php echo $info["userpassword"]?>" readonly/>
        </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="button" name="Return_to_market" value="Закрыть окно" onClick="window.close(self);return false;">
            </td>
        </tr>
        <tr>
            <td colspan="2">
            </td>
        </tr>
    </table>
</form>



