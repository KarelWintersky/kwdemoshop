<?php
require_once "lib_gd.php";
session_start();
global $CONFIG;
$gallery_content = LoadGallery();
$gallery_count = count($gallery_content);
?>
<html>
<head>
    <link type="text/css" rel="stylesheet" href="admin.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

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
            if (confirm('??????????? ???????. ??????? ?????')){window.close(self);}
        }
    </script>
</head>
<body>

<div id="admin_menu">
    <?php include "admin_menu.php"; ?>
</div>


<div id="content">
    <input type="button" name="NewImage" value="Новое изображение" onClick="document.location.href='image_add.php'" />

    <table border="0">
        <tr><td>Количество изображений:</td><td><?php echo count($gallery_content); ?></td></tr>
        <?php
        if (0==count($gallery_content))
        {
            ?>
            <tr><td colspan="2">Изображений нет!</td></tr>
            <?
        }
        else
            foreach ($gallery_content as $id=>$entry) { ?>
                <tr>
                    <td>
                        <table border="1" bordercolor="red">

                            <tr>
                                <td width="122" id="d<?php echo $entry["id"]?>" class="myTblTD2">
                                    <a href="javascript://" title="???????" onClick="select_i('<?php echo $entry["id"] ?>');return false;">
                                        <img src="image_preview.php?id=<?php echo $entry["id"]?>" border="0" style="border:1px solid #C0C0C0;"/>
                                    </a><br /><a title="???????" href="javascript://" onClick="select_i('<?php echo $entry["id"] ?>');return false;"><small>123</small></a>
                                </td>
                                <td width="400"><?php echo $entry["comment"]."&nbsp;";?> </td>
                            </tr>
                            <tr>
                                <td>Управление:</td>
                                <td>
                                    <a href="image_show.php?id=<?php echo $entry["id"]?>" rel="lightbox" title="...">....</a><br>
                                    <input type="button" name="GetLink" value="Показать изображение" onClick="window.open('image_show.php?id=<?php echo $entry["id"]?>','','scrollbars=1,width=830,height=550,top=100,left=100')" /><br>
                                    <input type="button" name="GetLink" value="Редактировать" onClick="document.location.href='image_edit.php?id=<?php echo $entry["id"]?>'" /><br>
                                    <?php
                                    if ($entry['deleted']) print('<span class="warning">???????? ?? ????????</span>');
                                    ?>
                                </td>
                            </tr>
                            </td>
                        </table>

                </tr>
                <? } ?>
    </table>
</div>

</body>
</html>