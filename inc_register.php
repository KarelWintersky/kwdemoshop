<?php
// FIX_01: вставить валидатор формы регистрации
?>
<form action="ub_register.php" method="post">
    <br><br>
    <table border="0" width="640">
        <tr>
            <td>Идентификатор <br>пользователя:</td>
            <td colspan="2"><input type="text" name="username" tabindex="1"><br>
                <small><i>Внимание, идентификатор - <b>не</b> имя пользователя и не может содержать русских букв!!!</i></small></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td><input type="text" name="password" tabindex="2" /></td>
            <td align="right">Подтвердите: <input type="text" name="confirm_pass" tabindex="3" /><td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td colspan="2"><input type="text" name="name" size="35" tabindex="4" /></td>
        </tr>
        <tr>
            <td>Фамилия:</td>
            <td colspan="2"><input type="text" name="surname" size="35" tabindex="5" /></td>
        </tr>
        <tr>
            <td>Отчество:</td>
            <td colspan="2"><input type="text" name="patro" size="35" tabindex="6" /></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><input type="text" name="phone" tabindex="6" /></td>
            <td align="right">E-Mail: <input type="text" name="email" tabindex="7" /></td>
        </tr>
        <tr>
            <td valign="top">Адрес доставки:</td>
            <td colspan="2"><textarea style="margin-bottom: 20px;" name="delivery_addr" cols="60" rows="4" tabindex="8"></textarea></td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="go_register" value="Подтвердить" src="images/submit_order.png" tabindex="10">
            </td>
            <td></td>
            <td align="right">Получать нашу рассылку <input type="checkbox" value="" tabindex="9" name="is_subscribe">
            </td>
        </tr>
    </table>
    <?php
    if ($_GET['return']=='cart') echo '<input type="hidden" name="return_to" value="cart" />';
    ?>
</form>











