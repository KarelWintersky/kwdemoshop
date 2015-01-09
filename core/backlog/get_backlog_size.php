<?php
require_once "../backlog.lib.php";

$link = ConnectDB();

print(GetBacklogSize());

CloseDB($link);
?>