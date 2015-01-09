<?php
?>
<div id="subscribe1">
    <script type="text/javascript">
        hs.outlineType = "beveled";
        hs.anchor = "auto";
        hs.align = "center";
        hs.dimmingOpacity = "0";
    </script>

    <div align="center">
        <a href="javascript:void(0)" onclick="return hs.htmlExpand(this,{contentId:'subscribe', width: 260})" title="Регистрация" class="highslide">
        </a>
    </div>

    <div class="highslide-html-content" id="subscribe" style="overflow: hidden;">
        <div class="highslide-html-content-header">
            <div class="highslide-move" title="Переместить">
                <a class="control" title="Закрыть" onclick="hs.close('subscribe')" href="javascript:void(0)">X</a>
            </div>
        </div>

        <div class="highslide-body" id="body_subscibe" style="overflow: hidden; text-align:left;	height:80px !important;">
            E-Mail: <input type="text" name="email" size="32">
            <div style="text-align: center;"><br>
                <input type="submit" value="Подписаться!">
            </div>
        </div>

    </div>
    <script type="text/javascript">
        function close_subscribe() {
            hs.close('subscribe');
            return;
        }
    </script>
</div>

