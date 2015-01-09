<?php
session_start();
require_once "lib_shop.php";
$id = $_POST['id'];     // id товара в базе
$cart_pos = $_POST['cart_pos']; // позиция в корзине
if (IsSet($_POST['rnd982g']))
{

// пошли обрабатывать

    $product = array (
        'id' => $id,  // id товара
        'time' => time(),  // момент добавления
        'magic' => $_POST['rnd982g'], // магическое число
        'price_box' => $_POST['price_box'], // цена? нафик?
        'type' => $_POST['type'], // тип (нафик?)
        'num_left' => $_POST['num_left'], // количество левых
        'num_right' => $_POST['num_right'], // количество правых
        'color_left' => $_POST["color_left"],
        'color_right' => $_POST["color_right"],
        'op_left' => $_POST["op_left"],
        'op_right' => $_POST["op_right"],
        'bc_left' => $_POST["bc_left"],
        'bc_right' => $_POST["bc_right"],
        'producer' => $_POST["producer"],

        'axis_left' => $_POST["axis_left"],
        'axis_right' => $_POST["axis_right"],

        'cylinder_left' => $_POST["cylinder_left"],
        'cylinder_right' => $_POST["cylinder_right"],
    );
    /*
    Ненавижу самодовольного ублюдка чекстера. См order_action_insert
    Бля, щас как начнется заново отладка... хотя не должна быть вроде.
    if (($product['bc_left']==$product['bc_right'])&&    // проверяем - это один заказ или два рахных - на основе данных о линзах
        ($product['op_left']==$product['op_right'])&&
        ($product['color_left']==$product['color_right'])) $product['num_this'] = $_POST['num_right'];
        else $product['num_this'] = ($product['num_left']+$product['num_right']);
    */
    $product['num_this'] = ($product['num_left']+$product['num_right']);
    $product['order_cost'] = $product['num_this'] * $_POST['price_box'];

    // Не забываем обновить переменные  $_SESSION['cart_sumprice']
    // а почему мы этого не делаем тут? мю потому что мы их пересчитываем где-то в другом месте?

    unset($_SESSION['cart'][$cart_pos]);
    $_SESSION['cart'][$cart_pos] = $product;
    $msg = "Информация о заказе № $cart_pos изменена, новая сумма заказа ".PrintPrice($product['order_cost'],"RU","show");
    //  $msg.= '<input type="button" name="return" value="Закрыть окно" onClick="window.location.reload(this);hs.close(this);">';
    $msg.= '<input type="button" name="return" value="Назад" onClick="return close_hs('.$id.',\'result_'.$id.'\',this);hs.close(this);return false;">';
    echo $msg;
}
?>

