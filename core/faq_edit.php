<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");

require_once "lib_core.php";
$id = $_GET["id"];
$link = ConnectDB() or Die("Не удается соединиться с базой данных!");
$q = "SELECT * FROM faq WHERE (id=$id)";
$result = mysql_query($q) or Die("Не удается выполнить запрос к БД, строка запроса: [$q]");
$item = mysql_fetch_assoc($result) or Die("Не удается получить результат запроса ($q)");
CloseDB($link);
$sq = stripslashes(htmlspecialchars($item['question']));
$sa = $item['answer'];
?>
<head>
    <title>Редактор: консультация</title>
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="lightbox/lightbox.css">

    <script src="/core/js/core.js"></script>
    <script src="/core/js/tinymce/tinymce.min.js"></script>
    <script src="/core/js/tinymce.config.js"></script>
    <script type="text/javascript">
        tinify(tiny_config['full'], 'FAQ_Answer');
    </script>
</head>

<body>
<b>Вы работаете от имени пользователя: <?php echo $_SESSION["userinfo"]['username']; ?></b><br>
<form action="faq_action_update.php?id=<?php echo $id; ?>" method="post">
    Отредактируйте вопрос врачу:
    <input type="text" name="FAQ_Question" maxlen="50" size="100" value="<?php echo $sq; ?>"><br>
    Отредактируйте ответ врача:<br>

    <textarea name="FAQ_Answer" id="FAQ_Answer" cols="10" tabindex="3"><?php echo $sa; ?></textarea>

    <input type="submit" value="Сохранить" name="saveThis">
</form>
<input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='faq.php'" />
</body>








