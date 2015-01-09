<div id="login_button">
    <script type="text/javascript">
        hs.outlineType = "beveled";
        hs.anchor = "auto";
        hs.align = "center";
        hs.dimmingOpacity = "0";
    </script>
    <div class="amoduletitle_logo1" align="center">
        <a href="javascript:void(0)" onclick="return hs.htmlExpand(this,{contentId:'highslide-html-loginform', width: 250, wrapperClassName: 'draggable-header'})" title="Вход" class="highslide">
        </a>
    </div>

    <div class="highslide-html-content" id="highslide-html-loginform" style="overflow: hidden;">
        <div class="highslide-html-content-header">
            <div class="highslide-move" title="Переместить">
                <a href="javascript:void(0)" onclick="hs.close('highslide-html-loginform')" class="control" title="Закрыть">X</a>
            </div>
        </div>
        <div class="highslide-body" style="overflow: hidden;text-align:left;">
            <form action="ub_login.php" method="post" name="loginForm">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td>
                            <label for="alogin_username" class="alogin-labelusername">Пользователь</label>
                            <br>
                            <input name="username" id="alogin_username" class="inputbox" alt="username" size="10" type="text">
                            <br>
                            <label for="alogin_password" class="alogin-labelpassword">Пароль</label>
                            <br>
                            <input id="alogin_password" name="password" class="inputbox" size="10" alt="password" type="password"><input name="Submit" class="alogin-loginbutton" title="Войти" value="->" type="submit">
                            <br>
                            <div class="alogin-form-submit">
                                <!--                  <div class="alogin-form-input">
                                                    <input name="remember" id="alogin_remember" class="inputbox" value="yes" alt="Запомнить" title="Запомнить" type="checkbox">
                                                    <label for="alogin_remember" class="alogin-labelremember" title="Запомнить">Запомнить</label>
                                                  </div> -->

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="text-align: center; padding-top: 5px;">
                                <div style="margin: 0pt auto;">
                                    <noindex><a href="?action=remember_password" title="Забыли пароль" class="alogin-lostpassword" rel="nofollow">Забыли пароль</a></noindex> |
                                    <noindex><a href="?action=register" title="Регистрация" class="alogin-createaccount" rel="nofollow">Регистрация</a></noindex>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--        <div class="aimglogo"></div> -->
                <input name="return_to" value="<?php echo $_SESSION["the_mainscript"]; ?>" type="hidden">
                <input name="message" value="0" type="hidden">
                <input name="generate_time" value="<?php echo time(); ?>" type="hidden">
            </form>
        </div>
    </div>
    <script type="text/javascript">
        function close_login() {
            hs.close('highslide-html-loginform');
            return;
        }
    </script>
</div>

