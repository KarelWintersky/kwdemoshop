<?php
// Called from image_new.php to UPLOAD image
require_once "lib_gd.php";
// test magic number
{
    $upload_result = UploadImage($_FILES,$_POST);
    if (0!=$upload_result['ok']) $add_result = AddImageToDB($upload_result);
    $msg = $upload_result['msg']."<br>".$add_result['msg']."<br><br>";
    $id = $add_result["id"];
}
/* else
{
  $msg = $msg.": Изображение уже загружено, повторная загрузка блокирована! <br>\n";
}; */
?>
<html>
<head>
    <title>Изображение загружено!</title>

    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link rel="stylesheet" type="text/css" href="lightbox/lightbox.css" />
    <link rel="stylesheet" type="text/css" href="admin.css" />
    <script type="text/javascript" src="kernel.js"></script>

</head>

<body>
<?php echo $msg; ?>
<a href="image_show.php?id=<?php echo $id; ?>" rel="lightbox"><img src="image_preview.php?id=<?php echo $id;?>"/ title="Показать изображение в полный размер"></a>
<br>
<input type="button" value="Получить ссылку" onClick="link_to_image(<?php echo $id; ?>);return false;">
<br>
<input type="button" name="NewImage" value="Добавить еще одно изображение" onClick="document.location.href='image_add.php'" />
<br>
<input type="button" name="Return_to_gallery" value="Вернуться к галерее" onClick="document.location.href='images.php';return false;">
</body>
</html>
