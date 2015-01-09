<?php
session_start();
require_once "lib_core.php";
$link = ConnectDB();
unset($item);

$qa = array(
    'answer' => mysql_real_escape_string($_POST["FAQ_Answer"]),
    'time_create' => time(),
    'question' => mysql_real_escape_string($_POST["FAQ_Question"]),
    'user_name' => $_SESSION['userinfo']['fullname'],
    'user_id' => $_SESSION['userinfo']['id']
  );

  $qs = MakeInsert($qa,'faq');

  $res = mysql_query($qs,$link) or Die("Невозможно сохранить статью в БД!".$q);
  $new_id = mysql_insert_id() or Die("Невозможно получить id последней записи из БД! [$q]");
  mysql_close($link);
?>
<head>
    <script>
        // закрывает себя и обновляет родителя
        function RefreshAndClose(it)
        {
            window.opener.Refresh();
            window.close(it);
        }
    </script>
</head>
<body>
<div>
    Вопрос добавлен<br>
    <?php
    if ($_POST["caller"]==="admin") {
        ?>
        <input type="button" name="Return" value="Вернутся в контрольную панель" onClick="document.location.href='faq.php'" />
        <?php
    } else {
        ?>
        <input type="button" name="return" value="Вернуться" onClick="RefreshAndClose(this)">
        <?php
    }
    ?>
</div>

</body>

