<?php
session_start();
require_once "lib_core.php";
$link = ConnectDB();
unset($item);

$id = $_GET["id"];
$item["answer"] = mysql_real_escape_string($_POST["FAQ_Answer"]);
$item["question"] = mysql_real_escape_string($_POST["FAQ_Question"]);

mysql_query($q="UPDATE faq SET answer='".$item["answer"]."' WHERE id=$id") or Die("Не удается изменить вопрос консультационной статьи");
mysql_query($q="UPDATE faq SET question='".$item["question"]."' WHERE id=$id") or Die("Не удается изменить ответ консультационной статьи");
mysql_close($link);
?>
<head>
    <script type="text/javascript" src="kernel.js"></script>
</head>
<body>
<div>
    Ответ добавлен или отредактирован!<br>
    <!--  <a href="#" onClick="link_to_article(<?php echo $new_id; ?>)">Получить ссылку</a><br> -->
    <input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='faq.php'" />

</div>
<div id="a_preview">
    &nbsp;
</div>


</body>

