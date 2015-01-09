<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");
require_once "lib_core.php";
$magic = NewMagicNumber();
?>
<head>
    <title>Добавление новой рекламной акции</title>

    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css" />

    <script src="datepicker/datepicker.js" type="text/javascript" charset="UTF-8" language="javascript"></script>
    <link rel="stylesheet" type="text/css" href="datepicker/datepicker.css" />

    <link rel="stylesheet" type="text/css" href="admin.css" />
    <script type="text/javascript" src="kernel.js"></script>

    <script src="/core/js/core.js"></script>
    <script src="/core/js/tinymce/tinymce.min.js"></script>
    <script src="/core/js/tinymce.config.js"></script>
    <script type="text/javascript">
        tinify(tiny_config['full'], 'OfferText');
        tinify(tiny_config['simple'], 'OfferShort');
    </script>


    <script>
        // инициализирует SELECT-список с выбором группы пользователя
        // where - id select-списка
        // choosed - 0..5 - номер выбранной опции
        function OffersInit(where,choosed)
        {
            document.getElementById(where).options[0] = new Option("Гости", "0");
            document.getElementById(where).options[1] = new Option("Покупатели", "1");
            document.getElementById(where).options[2] = new Option("Лучшие покупатели", "2");
            document.getElementById(where).options[3] = new Option("VIP", "3");
            document.getElementById(where).options[4] = new Option("Менеджеры", "4");
            document.getElementById(where).options[5] = new Option("Администратор", "9");
            document.getElementById(where).options[choosed].selected = true;
        }

        function OfferCheckForm()
        {
            /* if(upload_form.DisplayStart.value.length == 0)
            {
                upload_form.DisplayStart.focus();
                alert("Пожалуйста, укажите дату начала акции!");
                return(false);
            }
            if(upload_form.DisplayEnd.value.length == 0)
            {
                upload_form.DisplayEnd.focus();
                alert("Пожалуйста, укажите дату окончания акции!");
                return(false);
            }
            if(upload_form.Rating.value.length == 0)
            {
                upload_form.Rating.focus();
                alert("Пожалуйста, укажите начальный рейтинг акции!");
                return(false);
            }
            if(upload_form.OfferText.value.length < 4)
            {
                upload_form.OfferText.focus();
                alert("Пожалуйста введите текст акции!");
                return(false);
            }
*/
        }
    </script>

    </head>

    <body onLoad="OffersInit('DisplayFor',0)">
            <b>Добавьте пожалуйста новую рекламную акцию:</b> <br><br>

    <form action="offer_action_insert.php" method="post" onSubmit="return(OfferCheckForm())" name="upload_form">
            <table border="0">
            <tr>
            <td>Название рекламной акции:</td>
            <td><input type="text" name="OfferTitle" maxlen="50" size="100"></td>
            </tr>
            <tr>
            <td>Дата начала показа: </td>
            <td><input name="DisplayStart">&nbsp;<input type="button" onclick="displayDatePicker('DisplayStart', false, 'dmy', '/');" style="background: url('datepicker/datepicker.jpg') no-repeat; width: 30px; border: 0px;"></td>
            </tr>
            <tr>
            <td>Дата конца показа: </td>
            <td><input name="DisplayEnd">&nbsp;<input type="button" onclick="displayDatePicker('DisplayEnd', false, 'dmy', '/');" style="background: url('datepicker/datepicker.jpg') no-repeat; width: 30px; border: 0px;"></td>
            </tr>
            <tr>
            <td>Рейтинг акции: </td>
            <td><input name="Rating" type="text" value="0"></td>
            </tr>
            <tr>
            <td>Показывать для группы: </td>
            <td><select name="DisplayFor" id="DisplayFor"></select> ..и всех <b>выше</b> по иерархии доступа.</td>
            </tr>
            <tr>
    <td colspan="2"><b>Краткий текст рекламной акции:</b><br>
            [Правила составления короткого описания]
    </td>
            </tr>
            <tr>
    <td colspan="2">

        <textarea name="OfferShort" id="OfferShort" cols="10" tabindex="3"></textarea>

            </td>
            </tr>

            <tr>
            <td colspan="2"><b>Полный текст рекламной акции:</b></td>
            </tr>
            <tr>
    <td colspan="2">

        <textarea name="OfferText" id="OfferText" cols="10" tabindex="3"></textarea>

            </td>
            </tr>
            <input type="hidden" name="TheMagicNumber" value="<?php echo $magic; ?>">
            <tr><td colspan="2"><input type="submit" value="Сохранить" name="saveThis"> </td></tr>
            </table>
            </form>
    <input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='offers.php'" />
            </body>



