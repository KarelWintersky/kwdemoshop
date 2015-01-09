<?php
session_start();
require_once "lib_core.php";
$a_id = $_GET["id"];
$id = ($_GET["id"]==="") ? 1 : $_GET["id"];
$link = ConnectDB() or Die("Не удается соединиться с базой данных!");
$result = mysql_query($q="SELECT * FROM ".$CONFIG['table_faq']." WHERE (id=$id)") or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
$item = mysql_fetch_assoc($result) or Die("Не удается получить результат запроса ($q)");
CloseDB($link);
?>
<body>
<div>
    <table border="1" width="100%">
        <tr>
            <td width="70px">Дата</td>
            <td width="100px"><?php echo PrintDate($item["time_create"]); ?></td>
            <td width="120px">Пользователь</td>
            <td><?php echo $item["user_name"]; ?></td>
        </tr>
        <tr>
            <td>Вопрос <br /></td>
            <td colspan="3"><?php echo stripslashes($item["question"]); ?></td>
        </tr>
        <tr>
            <td>Ответ</td>
            <td colspan="3"><?php echo stripslashes($item["answer"]); ?></td>
        </tr>
    </table>
</div>
</body>
