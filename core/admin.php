<?php
require_once "lib_core.php";

session_start();

if (!$_SESSION['is_admin']) header("Location: ../index.php");
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script type="text/javascript" src="kernel.js"></script>
    <script type="text/javascript" src="highslide/highslide.js"></script>
    <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
    <title>Главная страница управляющего раздела</title>
</head>

<body onLoad="showAnyFile('article_show.php?id=1','content')">

<div id="admin_menu">
    <?php include "admin_menu.php"; ?>
</div>

<div id="content">
</div>
</body>
</html>

