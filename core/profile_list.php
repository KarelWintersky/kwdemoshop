<?php
session_start();
if (!$_SESSION['is_admin']) header("Location: ../index.php");


require_once "lib_core.php";
$link=ConnectDB();
$q = "SELECT * FROM ".$CONFIG['table_users'];
$res = mysql_query($q) or Die("Невозможно получить список пользователей!");
$num_users = mysql_num_rows($res);
$userlist=array();
while ($data = mysql_fetch_assoc($res)) $userlist[$data['id']] = $data;
mysql_close($link);
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <style type="text/css">
        td {text-align:center;}
    </style>
    <script type="text/javascript" src="kernel.js"></script>
</head>
<body>

<div id="admin_menu">
    <?php include "admin_menu.php"; ?>
</div>

<div id="content">
    Количество пользователей:<?php echo count($userlist); ?><br>
    <table border="1">
        <tr>
            <td width="30"> # </td>
            <td>идентификатор</td>
            <td> ФИО </td>
            <td>Дата регистрации</td>
            <td>Дополнительно</td>
        </tr>
        <?php
        if ($num_users)
            foreach ($userlist as $i=>$v) {
                $fullname = $v['surname']." <br>".$v['name']." ".$v['patro'];
                ?>
                <tr>
                    <td><a href="javascript://" onClick="window.open('profile_show.php?id=<?php echo $i; ?>','Просмотр пользователя','scrollbars=1,width=600,height=470,top=120,left=60')"><?php echo $i; ?></a></td>
                    <td><?php echo $v['username']; ?></td>
                    <td><?php echo $fullname; ?></td>
                    <td><?php Print(PrintDate($v['register_date']))?></td>
                    <td><a href="javascript://" onClick="window.open('profile_show.php?id=<?php echo $i; ?>','Просмотр пользователя','scrollbars=1,width=600,height=470,top=120,left=60')">VIEW</a>
                        <a href="javascript://" onClick="window.open('profile_edit.php?id=<?php echo $i; ?>','Просмотр пользователя','scrollbars=1,width=600,height=470,top=120,left=60')">EDIT</a></td>
                </tr>
                <?php
            } else echo '<tr><td colspan="4">Пользователей не зарегистировано!</td></tr>';
        ?>
    </table>

</div>
</body>
</html>
