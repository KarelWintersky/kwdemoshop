<?php
session_start();
require_once "lib_shop.php";

$id = $_POST['id']; // - получаемый id товара... он гуляет по скриптам всквозную

$num_l = $_POST['num_left'];
$num_r = $_POST['num_right'];

$num = $num_l + $num_r;
$price_box = $_POST['price_box'];
// пошли обрабатывать

$product = array (
    'id' => $id,  // id товара
    'time' => time(),  // момент добавления
    'magic' => $_POST['rnd982g'], // магическое число

    'price_box' => $price_box, // цена? нафик?
    'type' => $_POST['type'], // тип (нафик?)

    'num_left' => $_POST['num_left'], // количество левых
    'num_right' => $_POST['num_right'], // количество правых

    'color_left' => $_POST["color_left"],
    'color_right' => $_POST["color_right"],

    'op_left' => $_POST["op_left"],
    'op_right' => $_POST["op_right"],

    'bc_left' => $_POST["bc_left"],
    'bc_right' => $_POST["bc_right"],

    'axis_left' => $_POST["axis_left"],
    'axis_right' => $_POST["axis_right"],

    'cylinder_left' => $_POST["cylinder_left"],
    'cylinder_right' => $_POST["cylinder_right"],

    'producer' => $_POST["producer"]
);
if ($num!=0)
{
    /*
    Ненавижу чекстера максима. Самодовольный ублюдок, не умеющий ставить задачи.
    Предыдущий комментарий был насквозь нецензурный.
    if (($product['bc_left']==$product['bc_right'])&&    // проверяем - это один заказ или два рахных - на основе данных о линзах
        ($product['op_left']==$product['op_right'])&&
        ($product['color_left']==$product['color_right']))
        {
          if ($_POST['num_right']==0) $product['num_this'] = $_POST['num_left'];
          else $product['num_this'] = $_POST['num_right'];
        } else $product['num_this'] = ($product['num_left']+$product['num_right']);
    */
    $product['num_this'] = ($product['num_left']+$product['num_right']);
    $product['order_cost'] = $product['num_this'] * $_POST['price_box'];

    if (IsSet($_POST['rnd982g']))
        if (IsSet($_SESSION['cart'])) {
            array_push($_SESSION['cart'],$product);
            $_SESSION['orders_num'] = $_SESSION['orders_num']+1;
            $_SESSION['cart_sumprice'] = $_SESSION['cart_sumprice'] + $product['order_cost'];
        } else
        {
            $_SESSION['cart'][1] = $product;
            $_SESSION['orders_num'] = 1;
            $_SESSION['cart_sumprice'] = $product['order_cost'];
        };
    $msg = " В корзину добавлено $product[num_this] ед. товара на сумму ".PrintPrice($product['order_cost'],"RU","show");
} else
{
    $msg = "Необходимо добавить хотя бы 1 товар! ";
}
$msg.= '<input type="button" name="Return_to_market" value="Назад" onClick="return close_hs('.$id.',\'result_'.$id.'\',this);hs.close(this);return false;">';
// FIX: FriendlyCounter recommended
echo $msg;
?>






