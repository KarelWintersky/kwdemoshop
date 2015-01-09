<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

// форма выбора и добавления изображений к товару
require_once "lib_gd.php";
session_start();
$gallery_content = LoadGallery();
$gallery_count = count($gallery_content);

?>
<head>
    <link type="text/css" rel="stylesheet" href="admin.css">
    <script type="text/javascript" src="kernel.js"></script>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">
    <script type="text/javascript">
        function select_i(n)
        {
            if (!window.opener || !window.opener.document.newgoods){return false;}
            window.opener.document.newgoods.image_id.value=n;
            window.opener.document.newgoods.image_link.value='image_show.php?id='+n;
            window.opener.document.links["image_here_preview"].href='image_preview.php?id='+n;
            window.opener.document.links["image_here_full"].href='image_show.php?id='+n;
            if (confirm('Изображение выбрано. Закрыть окно?')){window.close(self);}
        }
    </script>
</head>
<body>

<input type="button" name="NewImage" value="Добавить изображение" onClick="document.location.href='image_add.php'" />

<table border="0">
    <tr><td>Количество изображений:</td><td><?php echo count($gallery_content); ?></td></tr>
    <?php
    if (0==count($gallery_content))
    {
        ?>
        <tr><td colspan="2">Галерея пуста!</td></tr>
        <?
    }
    else
        foreach ($gallery_content as $id=>$entry) { ?>
            <tr>
                <td>
                <table border="1" bordercolor="red">

                    <tr>
                        <td width="122" id="d<?php echo $entry["id"]?>" class="myTblTD2">
                            <a href="javascript://" title="Выбрать" onClick="select_i('<?php echo $entry["id"] ?>');return false;">
                                <img src="image_preview.php?id=<?php echo $entry["id"]?>" border="0" style="border:1px solid #C0C0C0;"/>
                            </a><br /><a title="Выбрать" href="javascript://" onClick="select_i('<?php echo $entry["id"] ?>');return false;"><small>Выбрать</small></a>
                        </td>
                        <td width="400"><?php echo $entry["comment"]."&nbsp;";?> </td>
                    </tr>
                    <tr>
                        <td>Управление:</td>
                        <td>
                            <a href="image_show.php?id=<?php echo $entry["id"]?>" rel="lightbox" title="Полное изображение">Показать в этом окне</a><br>
                            <input type="button" name="GetLink" value="Показать отдельно" onClick="window.open('image_show.php?id=<?php echo $entry["id"]?>','','scrollbars=1,width=830,height=550,top=100,left=100')" /><br>
                            <input type="button" name="GetLink" value="Редактировать" onClick="document.location.href='image_edit.php?id=<?php echo $entry["id"]?>'" /><br>
                            <?php
                            if ($entry['deleted']) print('<span class="warning">Помечено на удаление</span>');
                            ?>
                        </td>
                    </tr>

                </table>
                </td>

            </tr>
            <? } ?>
</table>

</body>
