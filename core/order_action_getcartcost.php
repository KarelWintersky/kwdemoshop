<?php
  require_once "lib_shop.php";
  $cart_cost = CalcCartCost();
  $cost_str = PrintPrice($cart_cost,"RU","show");
  echo $cost_str;
?>


