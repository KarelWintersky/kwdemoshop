<?php
session_start();
unset($_SESSION['cart']);
unset($_SESSION['cart_sumprice']);
unset($_SESSION['orders_num']);
?>
<input type="button" name="Return_to_market" value="Вернутся " onClick="document.location.href='index.php?action=cart';return false;">




