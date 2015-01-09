<?php
require_once "core/lib_shop.php";
require_once "core/logging.lib.php";
LogServerInfo();

$SID = session_id();
if(empty($SID)) session_start();

if (!IsSet($_SESSION['user_nickname'])) $_SESSION['user_nickname'] = 'guest'.strval(time());

$debug = 0;

// init values
unset($mode);
global $CONFIG;
$body_onload = '';
// set default values
// if (!session_is_registered("the_mainscript")) $_SESSION["the_mainscript"] = $_SERVER['PHP_SELF'];

$w_act = $_GET["action"];
$w_id = IsSet($_GET["id"]) ? $_GET["id"] : 1; //по умолчанию выводим самую первую статью

$my_cart = (IsSet($_SESSION['cart'])) ? $_SESSION['cart'] : array ('Корзина' => 'пуста');

if ($_SESSION['is_logged']) {$userinfo=$_SESSION['userinfo'];}
else {
    $userinfo = array (
        "username" => "Гость",
        "usergroup" => 0,
        "time" => time(),
        "fullname" => "Гость",
        "user_id" => 0
    );
    $_SESSION['userinfo'] = $userinfo;
}

if (!$userinfo['is_subscriber']) $mode['mailing_request'] = 1;

// switch to workmode по идее можно не плодить $mode[*] а перенести это сразу в тело content'а, но... как быть с include?
switch ($w_act) {
    case "article" :
    {
        //+ переход на статью
        $link = ConnectDB() or Die("Не удается соединиться с базой данных!");
        $q = "SELECT title,body FROM articles WHERE (id=$w_id)";
        $result = mysql_query($q) or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
        if (mysql_num_rows($result))
        {
            $entry = mysql_fetch_assoc($result) or Die("Не удается получить результат запроса ($q)");
            $the_title = stripcslashes($entry["title"]);
        } else
        {
            $entry["body"] = "Пока нет статьи.";
            $the_title = "Нет статьи!";
        }
        $mode['article'] = 1;
        // получение расширенного типа статьи см ниже
        /* FIX-01 - парсинг опционального параметра &type=smth
           получив type=xxx, мы должны опросить справочник ref_content_types, взяв оттуда extdata where id=xxx
           (
             справочник расширенного вида, кроме id,data содержит поле extdata типа TEXT
             в которое мы можем ввести какой-то html-кол
           )
           если EXTDATA не пусто - мы должны это вывести в nav_'диве, а саму статью в content'е
           ---
           default types:
             common - общие статьи, выводятся в КОНТЕНТ целиком
             gears - оправы
             salons - салоны
           ---
           НА ДАННЫЙ МОМЕНТ: эмуляция работы, если мы получили type=(gears|salons) - сделаем инклюд
        */
        if (IsSet($_GET["type"])) {
            switch ($_GET["type"]) {
                case "gears" : $mode['ext_article'] = "inc_menu_gears.php";break;
                case "salons" : $mode['ext_article'] = "inc_menu_salons.php";break;
                case "shop" : $mode['ext_article'] = "inc_menu_shop.php";break;
            }
        }
        CloseDB($link);
    };break;
    case "med_service" :
    {
        $the_title = "Консультация врача-офтальмолога";
        $items_list = LoadFAQ();
        $mode['medservice'] = 1;
    };break;
    case "shop" :
    {
        // интернет-магазин.  формат дополнительных параметров: (...)&&(...) - всё в скобках!!! sortby - критерий выборки & id - параметр выборки
        $the_title = "Онлайн магазин";
        if ($_GET["sortby"]=="")
        {
            $items_list = LoadMarket('id','DESC');
        } else
        {
            $sortby = $_GET["sortby"];
            $sortid = $_GET["id"];

// к сожалению приходится патчить код, потому что править логику некогда
// это не быстро, нужно подумать и возможно глобально переписать
// что-то. Не делаю этого, потому что изменение нужно как обычно "вчера", да и
// лень если честно.

            $sort_str = "$sortby=$sortid";
            if ($sortby!="type") $sort_str.=" AND type=1";

            $items_list = LoadMarket('id','DESC',$sort_str);
        }
        $mode['shop'] = 1;
        $_SESSION['is_shop'] = 1;
    };break;
    case "cart" :
    {
        $the_title = "Ваши текущие заказы";
        $mode['cart'] = 1;
    };break;
    case "backlog": {
        $the_title = "История заказов";
        $mode['backlog'] = 1;
    };break;
    case "editprofile" : {
        $the_title = "Редактировать профиль";
        $mode['editprofile'] = 1;
    };break;
    case "back_reporting" : {
        $the_title = "Связь с менеджером";
        $mode['manager_connect'] = 1;
    };break;
    case "register" : {
        $the_title = "Регистрация";
        $mode['register']=1;
    };break;
    case "confirm" :{
        $the_title = "Оформить заказ";
        $mode['confirm'] = 1;
    };break;
    case "offers" :{
        $the_title = "Рекламные акции";
        $mode['offers'] = 1;
        $curr_time = Time();
        $link = ConnectDB() or Die("Не удается соединиться с базой данных!");
        $q = "SELECT text FROM offerslist WHERE (display_start<=$curr_time)&&(display_end>=$curr_time) ORDER BY rating DESC LIMIT 3";
        $result = mysql_query($q);
        $offersnum = mysql_num_rows($result);
        $i=1;
        while ($data = mysql_fetch_assoc($result))
        {
            $offerslist[$i]=stripslashes($data["text"]);
            $i++;
        };
    };break;
    case "communicate" : {
        $the_title = "Связь с менеджером";
        $mode["communicate"] = 1;
    };break;
    case "debug" : {
        $mode["debug"] = 1;
    };break;
    case "remember_password" : {
        $mode["remember_password"] = 1;
    };break;
    case "showroom" : {
        $mode["showroom"] = 1;
        $body_onload = ' onload="GMapInit()" onunload="GUnload()"';
    };break;
    case "vacancy" : {
        $mode["vacancy"] = 1;
    };break;
    default: {
    $link = ConnectDB() or Die("Не удается соединиться с базой данных!");
    $q = "SELECT title,body FROM articles WHERE (id=2)"; // start article
    $result = mysql_query($q) or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
    $entry = mysql_fetch_assoc($result) or Die("Не удается получить результат запроса ($q)");
    $the_title = stripcslashes($entry["title"]);
    $the_text = stripslashes($entry["body"]);
    $curr_time = time();
    $q = "SELECT shortinfo FROM offerslist WHERE (display_start<=$curr_time)&&(display_end>=$curr_time) ORDER BY rating DESC LIMIT 3";
    $result = mysql_query($q);
    $offersnum = mysql_num_rows($result);
    $i=1;
    while ($data = mysql_fetch_assoc($result))
    {
        $offerslist[$i]=stripslashes($data["shortinfo"]);
        $i++;
    };
    // подготовим массив с тремя самыми популярными товарами
    $q = "SELECT * FROM market ORDER BY popular DESC LIMIT 3";
    $result = mysql_query($q);
    $productnum = mysql_num_rows($result);
    $i=1;
    while ($data = mysql_fetch_assoc($result))
    {
        $productlist[$i]=$data;
        $i++;
    };
    // в работу уходят: $the_title, $the_text, $offersnum, $offerslist[1,2,3]

    $mode['mainpage'] = 1;
    }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!--
Здравствуйте, коллега! А чего Вы, собственно, хотите тут увидеть? Обычный HTML-код :-)
Грязный и неотесанный. Местами некорректный. Но работает. :-)
-->
<html>
<head>
    <title>Оптика Зайди-Увидишь</title>
    <meta charset="utf-8">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
    <!-- CSS including -->
    <link href="layout.css" rel="stylesheet" type="text/css" media="screen">
    <link href="buttons.css" rel="stylesheet" type="text/css" media="screen">
    <link href="main.css" rel="stylesheet" type="text/css" media="screen">

    <link href="core/login/login.css" rel="stylesheet" type="text/css" media="screen">

    <?php
    If (IsSet($mode["shop"])||IsSet($mode["cart"]))
        echo '<link href="shop.css" rel="stylesheet" type="text/css" media="screen"/>';
    if ($mode["vacancy"])
    {
        echo '<link rel="stylesheet" type="text/css" href="core/datepicker/datepicker.css">';
        echo '<script src="core/datepicker/datepicker.js" type="text/javascript" charset="UTF-8" language="javascript"></script>';
    }
    ?>
    <script type="text/javascript" src="core/kernel.js"></script>

    <script type="text/javascript" src="highslide/highslide.js"></script>
    <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
    <!-- Highslide JS -->
    <script type="text/javascript">
        hs.outlineWhileAnimating = "true";
        hs.showCredits = 0;
        hs.expandDuration = "250";
        hs.loadingText = "загружаю...";
        hs.loadingTitle = "Клик для отмены";
        hs.transitions = '["expand"]';
    </script>
    <!-- HS JS end -->

    <?php
    if ($mode["showroom"])
    {
        echo '<script src="http://maps.google.com/maps?file=api&v=2&&hl=ru&key=ABQIAAAAJINnZ0d6a1pLDy3ky9dsJRRE8uKDqhn2fVBEeGx1gfXyB4et5hTziuretnhfN2mMD5dNAxO89Ki7Eg" type="text/javascript"></script>';
        echo "\r\n";
        echo '<script src="core/googlemap.js" type="text/javascript"></script>';
    }
    ?>

    <?php
    // logging.lib::using
    // этому полагается быть на самом верху, но это специально вынесено в одно место для понятности
    // visitcounter - счетчик посещений страницы, visittime - таймштамп посещения
    $currtime = time();
    $_SESSION['visitcounter']++;
    if ($_SESSION['visitcounter']==1) {
        $_SESSION['visittime']=$currtime;
    } else {
        if ((time()-$_SESSION['visittime'])>3600) {
            $_SESSION['visitcounter']=1;
            $_SESSION['visittime']=$currtime;
        }
    }

    if ($_SESSION['visitcounter']==1) LogUserInfo('подключить JQ');
    ?>

</head>

<body<?php echo $body_onload; ?>>

<div id="global_container">
<div id="static_header" style="cursor: pointer;" onClick="document.location='index.php'">
</div>

<div id="menu_top">
    <!-- кнопки основного меню -->
    <div id="b_cont_lenses">
        <a href="?action=shop">
            <img src="images/1x1.gif" height="15" width="141" border="0" alt="Контактные линзы"></a>
    </div>
    <div id="b_access">
        <a href="?action=article&id=31">
            <img src="images/1x1.gif" height="15" width="88" border="0" alt="Аксессуары"></a>
    </div>
    <div id="b_solar_glass">
        <a href="?action=article&id=2&type=gears">
            <img src="images/1x1.gif" height="15" width="166" border="0" alt="Солнцезащитные очки"></a>
    </div>
    <div id="b_gears">
        <a href="?action=article&id=2&type=gears">
            <img src="images/1x1.gif" height="15" width="62" border="0" alt="Оправы"></a>
    </div>
    <div id="b_opt_lenses">
        <a href="?action=article&id=25">
            <img src="images/1x1.gif" height="15" width="138" border="0" alt="Оптические линзы"></a>
    </div>
</div>

<div id="menu_middle_image">
</div>

<div id="menu_middle">
    <!-- Кнопки нижнего меню -->
    <div id="b_salons">
        <a href="?action=showroom">
            <img src="images/1x1.gif" height="15" width="64" border="0" alt="Наши салоны"></a>
    </div>
    <div id="b_about">
        <a href="?action=article&id=34">
            <img src="images/1x1.gif" height="15" width="94" border="0" alt="О Компании"></a>
    </div>
    <div id="b_vacancy">
        <a href="?action=vacancy">
            <img src="images/1x1.gif" height="15" width="77" border="0" alt="Наши вакансии"></a>
    </div>
    <div id="b_doctor">
        <a href="?action=med_service">
            <img src="images/1x1.gif" height="15" width="109" border="0" alt="Онлайн-консультация"></a>
    </div>
    <div id="b_go_shop">
        <a href="?action=shop">
            <img src="images/1x1.gif" height="15" width="57" border="0" alt="Открыть магазин"></a>
    </div>
</div>

<div id="menu_pop_buttons">
    <?php /*
    <div id="b_go_cart">
      <a _href="?action=cart">
        <img src="images/1x1.gif" height="29" width="37" border="0" alt="Открыть корзину"></a>
    </div>
        */ ?>
    <?php if ($_SESSION['is_logged']) { ?>
    <!-- кнопка появляется при залогиненом пользователе -->
    <div id="b_profile">
        <?php
        include "hs_userbar.php";
        ?>
    </div>
    <?php }; ?>
    <!-- а тут заканчивается описание этого дива-->

</div>

<div id="global_main">

    <div id="main_left">
        <!-- основное окно для контента-->

        <div id="content" class="main_content">
            <?php
            if ($mode['mainpage'])
            {
// выводим содержимое первой страницы
                ?>
                <div style="width:460px;overflow:hidden;float:left" id="mainpage_left">
                    <div>
                        <br><br><?php echo $the_text; ?><br><br>
                    </div>
                </div>
                <div style="width:260px;overflow:hidden;float:right" id="mainpage_right">
                    <?php
                    if (count($offerslist))
                        foreach ($offerslist as $i=>$v) { ?>
                            <div id="offer_<?php echo $i; ?>" style="padding-top:40px; padding-right:30px;">
                                <a href="?action=offers#offer_<?php echo $i; ?>"><?php echo $v; ?></a>
                            </div>
                            <?php } ?>
                </div>
                <?
            };
            if ($mode['article'])
            {
                if ($mode['ext_article'])
                {
                    $menu_file = $mode['ext_article'];
                    echo '  <div id="nav1">';
                    include "$menu_file";
                    echo '</div>';
                    echo ' <div id="list">';
                    echo stripcslashes($entry["body"]);
                    echo '</div>';
                }
                else echo stripcslashes($entry["body"]);
            };

            if ($mode['medservice']) include "inc_faq_list.php";

            if ($mode['shop'])
            {
                echo '  <div id="nav">';
                include "inc_menu_shop.php";
                echo '</div>';

                echo ' <div id="list">';
                include "inc_shop.php";
                echo '</div>';
            };
            if ($mode['cart']) {
                echo '  <div id="nav">';
                include "inc_menu_shop.php";
                echo '</div>';
                echo ' <div id="list">';
                include "inc_cart.php";
                echo '</div>';
            };
            if (isset($mode['confirm'])) include "inc_confirm.php";
            if (isset($mode['register'])) include "inc_register.php";
            if (isset($mode['debug'])) include "inc_debug.php";
            if (isset($mode["communicate"])) include "inc_communicate.php";
            if (isset($mode['editprofile'])) include "core/profile_edit.php";
            if (isset($mode["remember_password"])) include "inc_remember_password.php";
            if (isset($mode["showroom"])) include "inc_showroom.php";
            if (isset($mode['offers']) && count($offerslist))
                foreach ($offerslist as $i=>$v) { ?>

                    <div id="offer_<?php echo $i; ?>" style="padding-top:40px; clear:both;">
                        <?php echo $v; ?>
                    </div><hr width="80%">
                    <?php }

            if (isset($mode["vacancy"])) include "inc_resume_form.php";
            ?>

        </div>
        <!-- конец основного окна для контента-->
    </div>

    <div id="main_right">
        <!-- правое меню верх -->
        <div id="right_pop">
            <div id="bR_cart">
                <a href="?action=cart">
                    <img src="images/1x1.gif" height="29" width="37" border="0" alt="Открыть корзину"></a>
            </div>
            <div id="b_subscribe">
                <a href="?action=article&id=43"></a>
            </div>
        </div>   <!-- right pop -->
        <div id="right_main">

            <?php
            if (!$_SESSION['is_logged'])
            {
                echo '<div id="bR_login">';
                include "hs_login.php";
                echo '</div>';
            }
            if ($_SESSION['is_logged'])
            {
                echo '<div id="bR_logout">';
                include "hs_logout.php";
                echo '</div>';
            }
            ?>
            <div id="b_offers">
                <a href="?action=offers"></a>
            </div>
            <div id="b_healer">
                <a href="?action=article&id=83"></a>
            </div>
            <div id="b_color"> <!-- на самом деле ремонт -->
                <a href="?action=article&id=44"></a>
            </div>
            <div id="b_repair"> <!-- на самом деле статьи -->
                <a href="?action=article&id=42"></a>
            </div>

            <!-- end of right_main -->
        </div>

        <!-- конец основного окна для навигаций-->
    </div>

</div>

<div id="global_footer">
    <table border="0" width="100%" style="background: url(images/footer_bg.png)">
        <tr>
            <td align="right" width="76%">
                <?php InsertSWFObject('images/fl-2.swf','23','706') ?>
            </td>
            <td align="center" width="12%">
                &nbsp;<img src="images/kodak.png">
            </td>
            <td>
                <img src="images/zeiss.png">
            </td>
        </tr>
    </table>


    <!--    <div id="conditions">
      <div id="b_deliver">
          <a href="?action=article&id=36&type=shop">
          <img src="images/1x1.gif" height="15" width="166" border="0" alt="Доставка"></a>
      </div>
      <div id="b_paytypes">
          <a href="?action=article&id=37&type=shop">
          <img src="images/1x1.gif" height="15" width="166" border="0" alt="Формы оплаты"></a>
      </div>
      <div id="b_garant">
          <a href="?action=article&id=38&type=shop">
          <img src="images/1x1.gif" height="15" width="166" border="0" alt="Гарантии"></a>
      </div>

      <div id="x_gismeteo">
      <img src="images/gismeteo.gif">
      <?php
    include "inc_gismeteo.php";
    ?>
       </div> -->
</div>

</div>

</div>
</body>
</html>




























