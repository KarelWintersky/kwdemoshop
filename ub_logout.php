<?php
// logout script
$SID = session_id();
if(empty($SID)) session_start();
print_r($_SESSION);
$callback = "/";
$_SESSION['is_logged']=0;
$_SESSION['is_ishop'] = 0;
// foreach ($_SESSION as $key) session_unregister($key);
session_destroy();
?>
<html>
<head>
    <meta http-equiv="refresh" content="0;url=<?php echo $callback; ?>">
    <style>
        html {
            background: black;
        }
    </style>
</head>
</html>



