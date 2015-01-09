<?php
require_once "lib_core.php";

if ($mode = IsSet($_GET["mode"])) {
    $is_preview = ($mode == "preview") ? 1 : 0;
}

$is_preview = ($_GET["mode"]=="preview") ? 1 : 0;
$id = $_GET["id"];
$link = ConnectDB() or Die("Не удается соединиться с базой данных!");
$q = "SELECT title,text FROM offerslist WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
$offer = mysql_fetch_assoc($result) or Die("Не удается получить результат запроса ($q)");
CloseDB($link);
?>
<title>
    <?php
    echo stripcslashes($offer["title"]);
    ?>
</title>
<body>
<div>
    <?php
    echo stripcslashes($offer["text"]);
    ?>
</div>
</body>
