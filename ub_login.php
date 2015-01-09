<?php
$pause = array (
    'correct' => 2,
    'badpass' => 10,
    'nouser' => 10
);

require_once "core/lib_core.php";
require_once "core/logging.lib.php";
/*
Мы получим данные (метод POST):
username - имя
password - пароль
remember - галочка - (если установлена - придет значение "yes")
generation_time - время генерации страницы
*/
// $SID = session_id();
// if(empty($SID)) session_start();

$username = strtolower($_POST['username']);
$password = $_POST['password'];
$md5pass = md5($password);
$remember = $_POST['remember'];
$callback = $_POST['return_to'];
$a_callback = '/index.php';

// проверим данные входа!
ConnectDB();
$q = "SELECT * FROM userlist WHERE username='$username'";
$res = mysql_query($q) or die("Не удается выполнить запрос к базе пользователей".$q);
$user_exists = mysql_num_rows($res);
print_r($user_exists);
if ($user_exists) {
    // пользователь существует
    $db_data = mysql_fetch_assoc($res);
    if ($db_data['userpassword']===$md5pass)
    {
        // new! 14-11-2014
        $SID = session_id();
        if(empty($SID)) session_start();

        // пароль верен
        $_SESSION['is_logged']=1;
        $db_data['fullname'] = $db_data['surname'].' '.$db_data['name'].' '.$db_data['patro'];
        $_SESSION['userinfo'] = $db_data; // а фигли, храним сразу ассоциативку!
        $is_admin = 0;
        if ($db_data['usergroup']>999) $is_admin=1;
        $_SESSION['is_admin'] = $is_admin;

        $_SESSION['user_nickname'] = $username;

        // LogSessionInfo();

        $message1 = "Вы вошли на сайт как ".$_SESSION['userinfo']['username'];
        $redirect_pause = $pause['correct'];
        $message2 = 'Через <span id="wait"><span id="zeit">'.$redirect_pause.'</span></span> секунды вы будете перемещены на <a href="index.php">начальную страницу</a> сайта.';
    }
    else {
        echo "user: [$username], pass: [$password], md5: [$md5pass]";
        $message1 = 'Пароль неверен, может быть вы попробуете снова:<br>
      <!--
      <form action="ub_login.php" method="post" name="loginForm">
        <input name="message" value="0" type="hidden">
        <label for="alogin_username" class="alogin-labelusername">Имя:</label>
        <input name="username" id="alogin_username" class="inputbox" alt="username" size="10" type="text">
        <br>
        <label for="alogin_password" class="alogin-labelpassword">Пароль</label>
        <input id="alogin_password" name="password" class="inputbox" size="10" alt="password" type="text">
        <br>
        <div class="alogin-form-submit">
        <input name="Submit" title="Войти" value="Войти" type="submit">
        </div>
      </form> -->';
        $redirect_pause = $pause['badpass'];
        $message2 = 'Через <span id="wait"><span id="zeit">'.$redirect_pause.'</span></span> секунды вы будете перемещены на <a href="index.php">начальную страницу</a> сайта.';
    };
};
if (!$user_exists)
{
    // пользователь не существует.
    // предложить зарегаться?
    $message1 = 'К сожалению такой пользователь не существует.<br>Может быть вы хотите <a href="index.php?action=register">зарегистрироваться</a>? ';
    $redirect_pause = $pause['nouser'];
    $message2 = 'Через <span id="wait"><span id="zeit">'.$redirect_pause.'</span></span> секунды вы будете перемещены на <a href="index.php">начальную страницу</a> сайта.';
};
// устанавливаем данные входа
?>
<html>
<head>
    <meta http-equiv="refresh" content="<?php echo $redirect_pause; ?>;url=<?php echo $a_callback; ?>">
    <script>
        var delay=<?php echo $redirect_pause ?>;
        var step=0.1;
        var pause=step;

        function CountDown()
        {
            if (delay==0) {
                document.getElementById('wait').innerHTML = '<span style="color:red" id="zeit"> СЕЙЧАС </span>';
                document.location.href="<?php echo $a_callback; ?>";
            }
            if(delay>0){
                document.getElementById('wait').innerHTML = '<span style="color:red" id="zeit"> ' + delay.toFixed(1) + ' </span>';
                delay=delay-step;
                setTimeout("CountDown('wait')", pause*1000);
            }
        }</script>
</head>
<style>
    a {
        color: red;
    }
    html {
        background: black;
    }
    body {
        color:black;
        font-size:18px;
    }
    div {
        padding-top: 14px;
        line-height: 1.3;
        width: 990px;
        height: 100px;
        margin-top: 150px;
        background: url('images/ub.png') no-repeat;
    }
</style>
<body onLoad="CountDown()">
<center>
    <div align="center">

        <?php echo $message1; ?>
        <br>
        <?php echo $message2; ?>
    </div>
</center>
</body>
</html>



