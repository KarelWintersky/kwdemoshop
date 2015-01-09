<?php
// это модуль редактирования товаров в базе
require_once "lib_shop.php";
session_start();

if (!$_SESSION['is_admin']) header("Location: ../index.php");

$mode = IsSet($_GET['mode']) ? $_GET['mode'] : "admin";
$market_content = LoadMarketAdmin('id','');
?>
<html>
<head>
    <title>Управление интернет-магазином</title>

    <script type="text/javascript" src="highslide/highslide.js"></script>
    <link type="text/css" rel="stylesheet" href="highslide/highslide.css">


    <link rel="stylesheet" type="text/css" href="admin.css">
    <style type="text/css">
        td {text-align:center;}
    </style>
    <script type="text/javascript" src="kernel.js"></script>

    <script type="text/javascript" src="hltable.js"></script>
    <link rel="stylesheet" type="text/css" href="hltable.css">

    <script>
        function ShowSorted(id,did)
        {
            sb_i = id.form.sort_by.selectedIndex;
            sb_v = id.form.sort_by.options[sb_i].value;
            so_i = id.form.sort_order.selectedIndex;
            so_v = id.form.sort_order.options[so_i].value;
            var url = 'goods_list.php?sortby='+sb_v+'&order='+so_v;
            makeRequest(url,document.getElementById(did));
            return false;
        }
    </script>
</head>
<body onLoad="showAnyFile('goods_list.php?sortby=id','goods_list_here')">

<div id="admin_menu">
    <?php include "admin_menu.php"; ?>
</div>

<div id="content">
    Количество товаров:  <?php echo count($market_content); ?><br>
    <input type="button" name="NewGoods" value="Добавить товар в базу" onClick="document.location.href='goods_add.php'" />
    <br><br>
    <form action="javascript://">
        Отсортировать по...
        <select name="sort_by" style="width: 300px">
            <option value="producer">производителю</option>
            <option value="title">названию товара</option>
            <option value="time_create">дате добавления</option>
            <option value="price">цене</option>
            <option value="popular">популярности</option>
        </select>
        Порядок:
        <select name="sort_order" style="width: 100px">
            <option value="asc">прямой</option>
            <option value="desc">обратный</option>
        </select>
        <input type="button" value="Показать" onClick="ShowSorted(this,'goods_list_here')">
    </form>

    <table border="1" width="100%">
        <tr>
            <td colspan="5">Вывести с сортировкой по... <a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=id','goods_list_here')"> умолчанию (id)</a></td>
        </tr>
        <tr>
            <td>производителю<br>
                <small>
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=producer&order=desc','goods_list_here')">от А до Я</a>)<br>
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=producer&order=asc','goods_list_here')">от Я до А</a>)
                </small>
            </td>
            <td>
                Названию<br>
                <small>
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=title&order=asc','goods_list_here')">от А до Я</a>)
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=title&order=desc','goods_list_here')">от Я до А</a>)
                </small>
            </td>
            <td >... дате добавления<br>
                <small>
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=date&order=desc','goods_list_here')">старые первые</a>)<br>
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=date&order=asc','goods_list_here')">новые первые</a>)
                </small>
            </td>
            <td>цене<br>
                <small>
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=price&order=asc','goods_list_here')">дешевые первые</a>)<br>
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=price&order=desc','goods_list_here')">дорогие первые</a>)
                </small>
            </td>
            <td>популярности<br>
                <small>
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=popular&order=desc','goods_list_here')">популярные</a>)
                    (<a href="javascript://" onClick="showAnyFile('goods_list.php?sortby=popular&order=asc','goods_list_here')">непопулярные</a>)
                </small>
            </td>
        </tr>
    </table>
    <!-- ztCMS: Вообще то так работать не должно... но почему-то работает :) -->
    <table border="0" id="here" width="100%">
        <tr>
            <td>
                <div id="goods_list_here" >
                </div>
            </td>
        </tr>
    </table>

</div>
<script type="text/javascript">
    highlightTableRows("here","hoverRow");
</script>

</body>

</html>

