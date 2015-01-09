<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

require_once "lib_gd.php";
// image_action.php?action=new&id=..
$CONFIG['was_uploaded'] = 0;
$magic = NewMagicNumber();
?>
<html>

<head>
    <title>Новое изображение</title>

    <link rel="stylesheet" type="text/css" href="admin.css" />
    <script type="text/javascript" src="kernel.js"></script>

    <script>
        function CheckForm()
        {
            if(upload_form.imagefile.value.length == 0)
            {
                upload_form.imagefile.focus();
                alert("Пожалуйста, укажите изображение для загрузки!");
                return(false);
            }
        }
    </script>
</head>

<body>
Введите пожалуйста комментарий и укажите файл с изображением:<br>
<form enctype="multipart/form-data" action="image_upload.php" method="POST" name="upload_form" onSubmit="return(CheckForm())">
    <textarea cols="60" rows="3" wrap="virtual" name="image_comment"></textarea><br>
    <input name="imagefile" type="file" /><br>
    <br>
    <input type="hidden" name="TheMagicNumber" value="<?php echo $magic; ?>">
    <input type="submit" value="Загрузить изображение"/ >
</form>
<br><br><br>
<input type="button" name="Return_to_gallery" value="Вернуться к галерее" onClick="document.location.href='images.php';return false;">
</body>
</html>

