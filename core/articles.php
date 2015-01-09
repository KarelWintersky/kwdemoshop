<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

require_once "lib_core.php";
$link = ConnectDB();
$req = "SELECT * FROM ".$CONFIG['table_articles']." ORDER BY id DESC";
$result = mysql_query($req) or Die("Невозможно получить список статей из базы");
$num_articles = mysql_num_rows($result);
for ($i=0;$i<$num_articles;$i++)
{
    $one_article = mysql_fetch_array($result);
    $id = $one_article["id"];
    $article_list[$id]=$one_article;
}
mysql_close($link);
?>
<head>
    <title>Управление текстовым контентом</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script type="text/javascript" src="kernel.js"></script>
    <script type="text/javascript" src="highslide/highslide.js"></script>
    <link rel="stylesheet" type="text/css" href="highslide/highslide.css">
    <script type="text/javascript" src="hltable.js"></script>
    <link rel="stylesheet" type="text/css" href="hltable.css">
</head>
</head>

<body>

<div id="admin_menu">
    <?php include "admin_menu.php"; ?>
</div>

<div id="content">
    <input type="button" name="NewArticle" value="Добавить статью" onClick="document.location.href='article_add.php'" />

    <br>
    Количество статей в базе: <?php echo count($article_list); ?><br>
    <table border="1" bordercolor="blue" width="100%" id="article_list">
        <tr>
            <th width="7%">#</th>
            <th width="20%"><small>Последняя<br>правка</small></th>
            <th>Название</th>
            <th>Управление</th>
        </tr>
        <?php
        if (0==count($article_list))
        {
            ?>
            <tr><td colspan="4" align="left">Статей нет.</td></tr>
            <?php
        }
        else
            foreach ($article_list as $id=>$entry)
            {
                ?>
                <tr>
                    <td width="10%" align="center">
                        <a href="#" onClick="link_to_article(<?php echo $entry["id"] ?>);return false;">
                            <small><?php echo $id; ?></small>
                        </a>
                    </td>
                    <td align="center">
                        <?php echo PrintTime($entry["time_modify"]); ?>
                    </td>
                    <td align="left">
                        <?php echo stripslashes($entry["title"]); ?>
                    </td>
                    <td>
                        <a href="article_show.php?id=<?php echo $entry["id"]; ?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax', align:'center'} )">
                            Показать
                        </a>
                        <br>

                        <a href="article_edit.php?id=<?php echo $id; ?>">Редактировать</a>
                        <?php
                        if ($article_list['deleted']) print('<span class="warning">Помечено на удаление</span>');
                        ?>
                        <br>
                        <a >
                    </td>
                </tr>
                <?php
            }
        ?>
    </table>
</div>
<script type="text/javascript">
    highlightTableRows("article_list","hoverRow");
</script>
</body>

