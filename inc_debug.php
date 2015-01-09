<?php
session_start();
echo 'Current locale: '.SetLocale(LC_ALL, "");
?>
<br><br><br>
<ul>
    <li><a href="?action=editprofile">Редактировать профиль</a>
    <li><a href="debug_init.php">Очистить корзину</a>
    <li><a href="?action=communicate">Связаться с менеджером</a>
</ul>
<hr width="80%">
<fieldset>
    Корзина:
<pre class="fixedheight" max-height:20em>
<?php
    print_r($_SESSION['cart']);
    ?>
</pre>
</fieldset>

<fieldset>
    Пользователь:
<pre class="fixedheight" style="max-height:25em">
<?php
    print_r($_SESSION['userinfo']);
    ?>
</pre>
</fieldset>

<fieldset>
    Переменные сессии:
<pre class="fixedheight" max-height:20em>
<?php
    print_r($_SESSION);
    ?>
</pre>
</fieldset>

<fieldset>
    Массив данных сервера:
<pre class="fixedheight" max-height:20em>
<?php
    print_r($_SERVER);
    ?>
</pre>
</fieldset>

