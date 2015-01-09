<?php
$title = "Управление рассылкой";
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");
require_once "lib_core.php";

$id = IsSet($_GET['id']) ? $_GET['id'] : "0";
// $sw = new SPAW_Wysiwyg('Mail_Text','%USERNAME%');

?>
<html>
<head>
    <title>Рассылка сообщений</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script type="text/javascript" src="kernel.js"></script>
    <script type="text/javascript" src="highslide/highslide.js"></script>
    <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
    <script>
        function cb(span)
        {
            span.parentNode.style["fontWeight"] = span.checked ? "bold" : "";
            span.parentNode.style["color"] = span.checked ? "red" : "black";
        }
        function ClearInner(id)
        {
            id.innerHTML='';
        }
        function ClearVal(id)
        {
            id.value='';
        }
    </script>
    <script src="/core/js/core.js"></script>
    <script src="/core/js/tinymce/tinymce.min.js"></script>
    <script src="/core/js/tinymce.config.js"></script>
    <script type="text/javascript">
        tinify(tiny_config['full'], 'Mail_Text');
    </script>
</head>
<body>
<div id="admin_menu">
    <?php include "admin_menu.php"; ?>
</div>
<div id="content">
    Рассылка сообщений пользователям нашего сайта:<br>
    <br>
    <form action="dispatch_script.php" method="post">
        <table border="1" width="99%">
            <tr>
                <td width="30%">Заголовок сообщения</td><td><input type="text" name="mail_subject" size="60" maxlenght="60" value="Укажите здесь заголовок сообщения" onFocus="ClearVal(this)"></td>
            </tr>
            <tr>
                <td>
                    Кому вы рассылаете сообщение?
                </td>
                <td>
                    <!--              недоступно до введния таблицы BACKLOG в работу -->
                    <!--            <nobr><input type="checkbox" onClick="cb(this)" name="sendgroup[]" value="0">Гости</nobr> -->
                    <nobr style="font-weight:bold;color:red"><input type="checkbox" onClick="cb(this)" name="sendgroup[]" value="1" checked>Покупатели</nobr>
                    <nobr><input type="checkbox" onClick="cb(this)" name="sendgroup[]" value="2">Лучшие покупатели</nobr>
                    <nobr><input type="checkbox" onClick="cb(this)" name="sendgroup[]" value="3">VIP</nobr>
                    <nobr><input type="checkbox" onClick="cb(this)" name="sendgroup[]" value="4">Менеджеры</nobr>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Введите сообщение. Помните, что использовать изображения прямо в тексте письма нельзя!<br>
                    Внимание, имя пользователя заменяется в тексте псевдотегом <b style="border:1px;border-style:solid">%USERNAME%</b> и вставится автоматически.

                    <textarea name="Mail_Text" id="Mail_Text" cols="10" tabindex="3"></textarea>

                </td>
            </tr>
            <tr>
                <td colspan="2"><br>
                    <input type="reset" style="float:left;margin-left:25px;" value="Очистить форму">
                    <input type="submit" style="float:right;margin-right:25px;" value="Разослать">
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>



