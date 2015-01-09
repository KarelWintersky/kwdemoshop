<?php
require_once "lib_core.php";

/*
  Функция загружает список товаров магазина
  $mode - тип загрузки:
    'admin' - загружает все товары, в том числе помеченные на удаление
    *       - любое другое значение проставляется по умолчанию и считается, что показываем для пользователя
  $sort_order - способ сортировки
    id      - сортировка по ID, прямой порядок
    name    - сортировка по имени (поле title)
  $order    - порядок сортировки - DESC или нет. По умолчанию нет :)
*/
function LoadMarket($sortorder,$order,$selection="") // загружает список товаров магазина
{
    global $CONFIG;
    unset($goods_list);
    $link = ConnectDB();
    $select = ' WHERE (deleted=0)';
    if ($selection!="") $select.="&&(".$selection.")";

    switch ($sortorder) {
        case 'id' : $sortby = 'id'; break;
        case 'title' : $sortby = 'title';break;
        case 'date' : $sortby = 'time_create';break;
        case 'price' : $sortby = 'price_box';break;
        case 'popular' : $sortby = 'popular';break;
        case 'producer' : $sortby = 'producer';break;
        default: $sortby = 'popular'; break;
    };
    $sortby = 'popular';
    $q = "SELECT * FROM ".$CONFIG['table_market']." $select ORDER BY $sortby $order";

    $result = mysql_query($q) or Die("Невозможно получить список товаров из базы данных, [$q]");
    $num_goods = mysql_num_rows($result);
    for ($i=0;$i<$num_goods;$i++)
    {
        $one_goods = mysql_fetch_assoc($result);
        $id = $one_goods["id"];
        $one_goods["description"] = stripslashes($one_goods["description"]);
        $one_goods["title"]       = stripslashes($one_goods["title"]);
        $goods_list[$id]=$one_goods;
    }
    CloseDB($link);
    return $goods_list;
}


function LoadMarketAdmin($sort_by,$order) // загружает список товаров магазина
{
    global $CONFIG;
    unset($goods_list);
    $link = ConnectDB();
    switch ($sort_by) {
        case 'id' : $sortby = 'id'; break;
        case 'name' : $sortby = 'title';break;
        case 'title' : $sortby = 'title';break;
        case 'date' : $sortby = 'time_modify';break;
        case 'price' : $sortby = 'price_box';break;
        case 'popular' : $sortby = 'popular';break;
        default: $sortby = 'id'; break;
    };
    $q = "SELECT * FROM ".$CONFIG['table_market']." ORDER BY $sortby $order";

    $result = mysql_query($q) or Die("Невозможно получить список товаров из базы данных, [$q]");
    $num_goods = mysql_num_rows($result);
    for ($i=0;$i<$num_goods;$i++)
    {
        $one_goods = mysql_fetch_assoc($result);
        $id = $one_goods["id"];
        $one_goods["description"] = stripslashes($one_goods["description"]);
        $one_goods["title"]       = stripslashes($one_goods["title"]);
        $goods_list[$id]=$one_goods;
    }
    CloseDB($link);
    return $goods_list;
}


function LoadGoods($goods_id)
{
    global $CONFIG;
    unset($one_goods);
    $id = IsSet($goods_id) ? $goods_id : 1;
    $link = ConnectDB();
    $q = "SELECT * FROM ".$CONFIG['table_market']." WHERE (id=$id)";
    $result = mysql_query($q) or Die("Невозможно получить запись о товаре из базы данных,<br> [$q]");
    $one_goods = mysql_fetch_assoc($result);
    $one_goods["description"] = stripslashes($one_goods["description"]);
    $one_goods["title"]       = stripslashes($one_goods["title"]);
    $one_goods["short_info"]  = stripslashes($one_goods["short_info"]);
    CloseDB($link);
    return $one_goods;
}

// а зачем мы дуп сделали???
function LoadMarketStat($sortby,$order,$mode='user') // загружает список товаров магазина для статтистики
{
    global $CONFIG;
    unset($goods_list);
    $link = ConnectDB();
    if ($mode == 'admin') {
        $select_mode = ' ';
    } else {
        $select_mode = ' WHERE (deleted=0) ';
    }
    switch ($sortorder) {
        case 'id' : $sortby = 'id'; break;
        case 'name' : $sortby = 'title';break;
        case 'title' : $sortby = 'title';break;
        case 'date' : $sortby = 'add_date';break;
        case 'price' : $sortby = 'price_box_ru';break;
        case 'popular' : $sortby = 'popular';break;
        default: $sortby = 'id'; break;
    };
    $q = "SELECT * FROM ".$CONFIG['table_market']." $select_mode ORDER BY $sortby $order";

    $result = mysql_query($q) or Die("Невозможно получить список товаров из базы данных, [$q]");
    $num_goods = mysql_num_rows($result);
    for ($i=0;$i<$num_goods;$i++)
    {
        $one_goods = mysql_fetch_assoc($result);
        $id = $one_goods["id"];
        $one_goods["description"] = stripslashes($one_goods["description"]);
        $one_goods["title"]       = stripslashes($one_goods["title"]);
        $goods_list[$id]=$one_goods;
    }
    CloseDB($link);
    return $goods_list;
}



// загрузка истории товаров
function LoadBacklog($user_id)
{
    $uid = IsSet($user_id) ? $user_id : 1;
    global $CONFIG;
    unset($backlog);
    $link = ConnectDB();
    // сначала запросим содержимое корзины
    $q = "SELECT * FROM ".$CONFIG['table_backlog']." WHERE (user_id=$uid) ORDER BY add_time";
    $result = mysql_query($q) or Die("Невозможно получить содержимое корзины из базы данных, [$q]");
    $num_goods = mysql_num_rows($result);
    for ($i=0;$i<$num_goods;$i++)
    {
        $one_goods = mysql_fetch_array($result);
        $one_goods["add_date"] = date("d/M/Y H:i:s",$one_goods["add_date"]);
        $q ="SELECT preview_id FROM market WHERE (id=".$one_goods["goods_id"].")";
        $r_temp = mysql_query($q) or Die("Невозможно получить получить preview_id из базы данных, [$q]");
        $one_goods["preview_id"] = $r_temp["preview_id"];
        $goods_list[]=$one_goods;
    }
    CloseDB($link);
    return $goods_list;
}


function LoadFAQ()
{
    global $CONFIG;
    $link = ConnectDB();
    $req = "SELECT * FROM faq ORDER BY id DESC";
    $result = mysql_query($req) or Die("Невозможно получить данные из базы, [$req]");
    $num_items = mysql_num_rows($result);
    for ($i=0;$i<$num_items;$i++)
    {
        $one_item = mysql_fetch_assoc($result);
        $one_item["anwered"] = (strlen($one_item["answer"])!=0) ? 1 : 0;
        $id = $one_item["id"];
        $items_list[$id]=$one_item;
    }
    mysql_close($link);
    return $items_list;
}

function CalcCartCost()
{
    session_start();
    if (!IsSet($_SESSION['cart'])) return 0;
    $ret_summ = 0;
    foreach ($_SESSION['cart'] as $cart_id => $cart_rec)
    {
        $ret_summ = $ret_summ + $cart_rec['order_cost'];
    }
    return $ret_summ;
}

?>