<?php
session_start();
?>
<html>
<!-- hs_faq_new_question begin -->
<head>
</head>
<body>
<form>
    <table border="0">
        <tr>
            <td align="right">
                <span style="font-weight: 600;">Ваше имя:</span>
            </td>
            <td>
                <input style="width: 270px; height: 20px; padding-left: 3px; margin-bottom: 6px;" type="text" name="FAQ_user_name" id="FAQ_user_name" value="<?php echo $_SESSION["userinfo"]["fullname"];?>"></textarea><br>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">
                <span style="font-weight: 600;">Введите&nbsp; вопрос:</span>
            </td>
            <td>
                <textarea style="width: 270px; padding-left: 3px;" title="required" name="FAQ_Question" id="FAQ_Question" cols="30" rows="5" value=""></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <div id="results">
                    <input type="button" id="quest_button" value="Задать вопрос"  onClick="ajaxFunction(this.form,'core/faq_action_insert_hs.php');return false;">
                </div>
            </td>
        </tr>
    </table>
    <div style="display:none">
        <input type="text" name="FAQ_user_id" id="FAQ_user_id" value="<?php echo $_SESSION["userinfo"]["id"];?>">
        <input type="text" name="FAQ_caller" id="FAQ_caller" value="user">
    </div>
</form>
</body>
</html>


