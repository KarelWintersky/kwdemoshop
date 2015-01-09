<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

require_once "lib_core.php";
// редактировать имеющуюся статью
$id = $_GET["id"];
$link = ConnectDB() or Die("Не удается соединиться с базой данных!");
$q = "SELECT * FROM offerslist WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
$offer = mysql_fetch_assoc($result) or Die("Не удается получить результат запроса ($q)");
CloseDB($link);
// $sw_text = new SPAW_Wysiwyg('OfferText',stripslashes($offer['text']));
// $sw_short = new SPAW_Wysiwyg('OfferShort',stripslashes($offer['shortinfo']));
$display_for = $offer["display_for"];
$display_pos = array (
    0 => "Гости",
    1 => "Покупатели",
    2 => "Лучшие покупатели",
    3 => "VIP",
    4 => "Менеджеры",
    5 => "Администратор",
    9 => "Системный оператор"
);
?>
<head>
    <title>Редактирование рекламной акции</title>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">
    <script src="datepicker/datepicker.js" type="text/javascript" charset="UTF-8"></script>
    <link rel="stylesheet" type="text/css" href="datepicker/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script type="text/javascript" src="kernel.js"></script>

    <script src="/core/js/core.js"></script>
    <script src="/core/js/tinymce/tinymce.min.js"></script>
    <script src="/core/js/tinymce.config.js"></script>
    <script type="text/javascript">
        tinify(tiny_config['full'], 'OfferText');
        tinify(tiny_config['simple'], 'OfferShort');
    </script>

</head>

<body>
<b>Отредактируйте пожалуйста рекламную акцию:</b> <br><br>

<form action="offer_action_update.php?id=<?php echo $id; ?>" method="post">
    <table border="0">
        <tr>
            <td>Название рекламной акции:</td>
            <td><input type="text" name="OfferTitle" maxlen="50" size="100" value="<?php echo stripslashes($offer["title"]); ?>"></td>
        </tr>
        <tr>
            <td>Дата начала показа: </td>
            <td><input name="DisplayStart" value="<?php echo PrintDate($offer["display_start"]); ?>">&nbsp;<input type="button" onclick="displayDatePicker('DisplayStart', false, 'dmy', '/');" style="background: url('datepicker/datepicker.jpg') no-repeat; width: 30px; border: 0px;"></td>
        </tr>
        <tr>
            <td>Дата конца показа: </td>
            <td><input name="DisplayEnd" value="<?php echo PrintDate($offer["display_end"]); ?>">&nbsp;<input type="button" onclick="displayDatePicker('DisplayEnd', false, 'dmy', '/');" style="background: url('datepicker/datepicker.jpg') no-repeat; width: 30px; border: 0px;"></td>
        </tr>
        <tr>
            <td>Рейтинг акции: </td>
            <td><input name="Rating" type="text" value="<?php echo $offer["rating"]; ?>"></td>
        </tr>
        <tr>
            <td>Показывать для группы: </td>
            <td><select name="DisplayFor" id="DisplayFor">
                <?php
                foreach ($display_pos as $i=>$v)
                    if ($i==$display_for) echo '<option value="'.$i.'" checked>'.$v.'</option>\n';
                    else echo '<option value="'.$i.'">'.$v.'</option>\n';
                ?>
            </select> ..и всех <b>выше</b> по иерархии доступа.</td>
        </tr>
        <tr>
            <td colspan="2"><b>Краткий текст рекламной акции:</b><br>
                [Правила составления короткого описания]
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <textarea name="OfferShort" id="OfferShort" cols="10" tabindex="3"><?php echo stripslashes($offer['shortinfo']); ?></textarea>
            </td>
        </tr>

        <tr>
            <td colspan="2"><b>Полный текст рекламной акции:</b></td>
        </tr>
        <tr>
            <td colspan="2">
                <textarea name="OfferText" id="OfferText" cols="10" tabindex="3"><?php echo stripslashes($offer['text']); ?></textarea>
            </td>
        </tr>
        <tr><td colspan="2"><input type="submit" value="Обновить" name="saveThis"> </td></tr>
    </table>
</form>

<div id="update_result">
    &nbsp;
</div>

<div id="remove_controls">

    <div name="DeleteOffer" style="<?php if ($offer["deleted"]==0) echo 'display: block'; else echo 'display: none'?>">
        <input type="button" name="bDeleteOffer" value="Пометить запись на удаление"
               onClick="showAnyFile('offer_action_delete.php?id=<?php echo $id ?>','remove_controls')">
    </div>

    <br>

    <div name="UnDeleteOffer" style="<?php if ($offer["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
        <input type="button" name="bUnDeleteOffer" value='Снять пометку "на удаление"'
               onClick="showAnyFile('offer_action_undelete.php?id=<?php echo $id ?>','remove_controls')">
    </div>

    <br>

    <div name="PurgeOffer" style="<?php if ($offer["deleted"]==0) echo 'display: none'; else echo 'display: block'?>">
        <input type="button" name="bPurgeOffer" value='Окончательно удалить запись из базы'
               onClick="showAnyFile('offer_action_purge.php?id=<?php echo $id ?>','remove_controls')">
    </div>

</div>

<input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='offers.php'" />
</body>




