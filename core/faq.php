<?php
require_once "lib_core.php";
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

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
?>
<head>
    <title>Управление мини-консультациями</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script type="text/javascript" src="kernel.js"></script>
    <script type="text/javascript" src="highslide/highslide.js"></script>
    <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
    <script type="text/javascript" src="hltable.js"></script>
    <link rel="stylesheet" type="text/css" href="hltable.css">
    <script>
        function confirm_purge(id,targ) {
            if (confirm('Вы уверены, что хотите удалить запись с номером '+id+' ?'))
            {
                req = 'faq_action_purge.php?id='+id;
                t = document.getElementById(targ);
                makeRequest(req,document.getElementById(targ));
                return false;
            }
        }
    </script>
</head>

<body>
<div id="admin_menu">
    <?php include "admin_menu.php"; ?>
</div>

<div id="content">
    <input type="button" name="NewFAQ" value="Добавить ЧАВО" onClick="document.location.href='faq_add.php'" />
    <br>
    Количество вопросов в базе: <?php echo count($items_list); ?><br>

    <table border="1" bordercolor="blue" width="90%" id="faq_list">
        <tr>
            <th width="10%">Пользователь</th>
            <th width="20%"><small>Дата</small></th>
            <th>Вопрос</th>
            <th>Действия</th>
        </tr>
        <?php
        if (0==count($items_list))
        {
            ?>
            <tr><td colspan="4" align="left">Пока никто не попросил консультацию.</td></tr>
            <?php
        }
        else
            foreach ($items_list as $id=>$item)
            {
                ?>
                <tr>
                    <td width="10%" align="center">
                        <small><?php echo $item["user_name"]; ?></small><br>
                        <small>[<?php echo $item["user_id"]; ?>]</small>
                    </td>
                    <td align="center">
                        <?php echo PrintTime($item["time_create"]); ?>
                    </td>
                    <td align="left">
                        <?php echo stripslashes($item["question"]); ?>
                    </td>
                    <td>
                        Ответ:
                        <a href="faq_edit.php?id=<?php echo $id;?>">Редактировать</a><br>
                        Вопрос:
                        <a href="faq_show.php?id=<?php echo $id; ?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax', align:'center'} )">
                            Посмотреть
                        </a> &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript://" onClick="return confirm_purge(<?php echo $id; ?>,'faq_remove_result_<?php echo $id; ?>')">Удалить</a>
                        <div id="faq_remove_result_<?php echo $id; ?>" style="color:red"></div>
                    </td>
                </tr>
                <?php
            }
        ?>
    </table>
</div>
<script type="text/javascript">
    highlightTableRows("faq_list","hoverRow");
</script>
</body>
