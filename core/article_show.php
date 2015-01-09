<?php
require_once "lib_core.php";
$id = ($_GET["id"]==="") ? 1 : $_GET["id"];
$link = ConnectDB() or Die("Не удается соединиться с базой данных!");
$q = "SELECT * FROM articles WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
$article = mysql_fetch_assoc($result) or Die("Не удается получить результат запроса ($q)");
CloseDB($link);
?>
<head>
    <title>
        <?php
        echo stripcslashes($article["title"]);
        ?>
    </title>
</head>
<body>
<div style="text-align:left">
    <?php
    echo stripcslashes($article["body"]);
    ?>
</div>
</body>

