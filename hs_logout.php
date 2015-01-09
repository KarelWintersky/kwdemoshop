<div class="b_logout">
    <a href="javascript:void(0)"
       onclick="return hs.htmlExpand(this,{
        contentId:'highslide-html-logoutform',
        wrapperClassName: 'mod_alogin',
        outlineType: 'beveled',
        align: 'center',
        anchor: 'auto',
        dimmingOpacity: '0',
        slideshowGroup: 'mod_alogin_logoutform'
      })" title="Выйти">
        <img src="images/1x1.gif" height="24" width="122" border="0" alt="Выход">
    </a>
    <div class="highslide-html-content" id="highslide-html-logoutform" style="width: 250px;">
        <div class="highslide-html-content-header">
            <div class="highslide-move" title="Переместить">
                <a href="javascript:void(0)" onclick="return hs.close(this)" class="control" title="Закрыть">X</a>
            </div>
        </div>
        <div class="highslide-body2">
            <p class="alogin-bold">Вы уверены, что хотите выйти?</p>
            <div class="alogin-logoutform">
                <form action="ub_logout.php" method="post" name="logout">
                    <input name="Submit" class="alogin-logoutbutton" title="Выйти" value="Выйти" type="submit">
                    <input name="option" value="logout" type="hidden">
                    <input name="return_to" value="<?php echo $_SESSION["the_mainscript"];?>" type="hidden">
                </form>
            </div>
        </div>
    </div>
</div>