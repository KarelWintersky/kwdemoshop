<?php
session_start();
require_once "lib_shop.php";
$cart_pos = $_GET['id']; // № удаляемой из корзинки записи
// пошли обрабатывать
$this_cost = $_SESSION['cart'][$cart_pos]['order_cost'];
$_SESSION['cart_sumprice'] = $_SESSION['cart_sumprice'] - $this_cost;

unset($_SESSION['cart'][$cart_pos]);

$cart_pos_msg = $cart_pos+1;
$msg = "Информация о заказе № $cart_pos_msg удалена!";
echo $msg;
?>

















