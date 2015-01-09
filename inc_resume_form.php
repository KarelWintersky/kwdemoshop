<?php
// FIX_01: вставить валидатор формы заполнения вакансии
?>
<p style="font-size: large;">В связи с открытием новых вакантных мест сеть оптик «Зайди-Увидишь» приглашает на работу целеустремленных, профессиональных, способных обучаться и стать частью нашей команды.</p>

<ul>В данный момент открытии вакансии:
    <li style="margin-left: -40px; font-size: medium;">Оптиков-оптометристов
    <li style="margin-left: -40px; font-size: medium;">Продавцов оптики
    <li style="margin-left: -40px; font-size: medium;">Врачей офтальмологов
</ul>

<ul>Мы гарантируем:
    <li style="margin-left: -40px; font-size: medium;">Достойную оплату труда
    <li style="margin-left: -40px; font-size: medium;">Лучшие условия работы
    <li style="margin-left: -40px; font-size: medium;">Комфорт и стабильность
    <li style="margin-left: -40px; font-size: medium;">Социальный пакет
    <li style="margin-left: -40px; font-size: medium;">Обучение
    <li style="margin-left: -40px; font-size: medium;">Индивидуальный подход к каждому соискателю
</ul>

<p><b>Наши контакты:</b>
<p>тел./факс: <b>601-68-06</b>
<p>тел.: <b>601-68-11</b>

<p>Заполните необходимые поля в приведенной ниже анкете и нажмите кнопку «ОТПРАВИТЬ», и мы свяжемся с Вами удобным для вас способом и в удобное время</p>
<form action="resume_action_send.php" method="post">
    <br><br>
    <table border="0" width="640">
        <tr>
            <td>Вакансия:</td>
            <td colspan="1"><input type="text" name="vacancy" tabindex="1"></td>
        </tr>
        <tr>
            <td>Фамилия:</td>
            <td colspan="1"><input type="text" name="surname" size="35" tabindex="2" /></td>
        </tr>
        <tr>
            <td>Имя:</td>
            <td colspan="1"><input type="text" name="name" size="35" tabindex="3" /></td>
        </tr>
        <tr>
            <td>Отчество:</td>
            <td colspan="1"><input type="text" name="patro" size="35" tabindex="4" /></td>
        </tr>
        <tr><td>Контакты:</td></tr>
        <tr>
            <td>Телефон:</td>
            <td><input type="text" name="phone" tabindex="5" /></td>
        </tr>
        <tr>
            <td>E-Mail</td>
            <td><input type="text" name="email" tabindex="6" /></td>
        </tr>
        <tr>
            <td valign="top">Дата рождения:</td>
            <td>
                <input name="birthdate" tabindex="7">
                <input type="button" style="background:url('core/datepicker/datepicker.jpg') no-repeat; width: 30px; border: 0px;"
                       onclick="displayDatePicker('birthdate', false, 'dmy', '/');">
            </td>
        </tr>
        <tr>
            <td>Гражданство</td>
            <td><input type="text" name="citizenship" tabindex="8" /></td>
        </tr>
        <tr>
            <td>Фактическое место проживания</td>
            <td><textarea name="livehere" cols="60" rows="4" tabindex="9"></textarea></td>
        </tr>
        <tr>
            <td colspan="2">  Образование: </td>
        </tr>
        <tr>
            <td>Полное название учебного заведения</td>
            <td><input type="text" name="school" tabindex="10" /></td>
        </tr>
        <tr>
            <td>специальность</td>
            <td><input type="text" name="speciality" tabindex="11" /></td>
        </tr>
        <tr>
            <td>дата окончания учебного заведения:</td>
            <td>
                <input name="enddate"  tabindex="12">
                <input type="button" style="background: url('core/datepicker/datepicker.jpg') no-repeat; width: 30px; border: 0px;"
                       onclick="displayDatePicker('enddate', false, 'dmy', '/');">
            </td>
        </tr>
        <tr>
            <td>Последнее место работы
                (наименование организации, должность)
            </td>
            <td><textarea name="last_work" cols="60" rows="4" tabindex="13"></textarea></td>
        </tr>
        <tr>
            <td>Опыт работы в  оптике, профессиональные навыки и знания</td>
            <td><textarea name="exp" cols="60" rows="4" tabindex="14"></textarea></td>
        </tr>
        <tr>
            <td>Дополнительная информация</td>
            <td><textarea name="addinfo" cols="60" rows="4" tabindex="15"></textarea></td>
        </tr>
        <tr>
            <td>Ваши пожелания и вопросы</td>
            <td><textarea name="wishes" cols="60" rows="4" tabindex="16"></textarea></td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="go_register" value="ОТПРАВИТЬ" src="images/submit_order.png">
            </td>
        </tr>
    </table>
</form>
