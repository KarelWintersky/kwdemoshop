<div id="userbar1">
    <script type="text/javascript">
        hs.outlineType = "beveled";
        hs.anchor = "auto";
        hs.align = "center";
        hs.dimmingOpacity = "0";
    </script>

    <div align="center">
        <a href="javascript:void(0)" onclick="return hs.htmlExpand(this,{contentId:'userbar', width: 250})" title="Управление" class="highslide">
        </a>
    </div>

    <div class="highslide-html-content" id="userbar" style="overflow: hidden;">
        <div class="highslide-html-content-header">
            <div class="highslide-move" title="Переместить">
                <a class="control" title="Закрыть" onclick="hs.close('userbar')" href="javascript:void(0)">X</a>
            </div>
        </div>

        <div class="highslide-body" style="overflow: hidden; text-align:left;">
            <!-- содержимое дива -->
            <ul style="margin-left:15px">
                <li>>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="?action=editprofile">Редактировать профиль</a>
            <li>>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="?action=communicate">Связаться с менеджером</a>
                <?php if ($_SESSION['is_admin']) {?>
                <li><hr width="40%">
                <li>>>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?action=debug">Отладка</a>
  <li>>>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="core/admin.php">Вход в панель управления</a>

                <? } ?>
            </ul>

            <!-- конец содержимого дива -->
        </div>

    </div>
    <script type="text/javascript">
        function close_userbar() {
            hs.close('userbar');
            return;
        }
    </script>
</div>

