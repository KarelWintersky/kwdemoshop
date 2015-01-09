<?php
require_once "lib_shop.php";
unset($goods);
// создаем сериализованные строки из списка выбранных чекбоксов
//  $str_opt_powers = ($_POST["optpwr"]) ? implode(",",$_POST["optpwr"]) : "";
//  $str_colors = ($_POST["colors"]) ? implode(",",$_POST["colors"]) : "";
//  $str_basecurves = ($_POST["basecurves"]) ? implode(",",$_POST["basecurves"]) : "";


// теперь разберемся с айди превью и картинки
// в данном случае они вынимаются из базы, хотя используя spaw-editor можно отказаться от базы картинок...
// и хранить все в файлах. может быть потом сделаем :)
$image_link = ($_POST['image_link']!='') ? trim($_POST['image_link']) : 'a=0';
$img_id =  substr($image_link,strrpos($image_link,'=')+1);

// начинаем вставку данных
$link = ConnectDB();
// запрос по-новому
$a = array (
    'title' => mysql_real_escape_string($_POST["GoodsName"]),
    'description' => mysql_real_escape_string($_POST["GoodsDescription"]),
    'short_info' => mysql_real_escape_string($_POST["short_info"]),
    'image_id' => $img_id,
    'preview_id' => $img_id,
    // теперь обработаем цены, очищать поля от концовочных рублей/копеек не нужно, только убирать символы ДО строки.
    'price_box' => 0 + $_POST["price_box_ru_hi"]*100 + $_POST["price_box_ru_lo"],
// параметры из строк
    'humidity' => $_POST['humidity'],
    'diameter' => $_POST['diameter'],
    'lenses_in_box' => $_POST["lenses_in_box"],
    'feature' => ($_POST["feature"]!="") ? $_POST["feature"] : "",
    'popular' => $_POST["popular"],
// параметры из селектов
    'producer' => $_POST['producer'],
//    'dou' => $_POST['dou'], // не хочет заказчик длительности использования
    'mow' => $_POST['mow'],
    'chroma' => $_POST['chroma'],
    'type' => $_POST['producttype'],
// параметры из чебоксов
    'basecurves' => ($_POST["basecurves"]) ? implode(",",$_POST["basecurves"]) : "",
    'colors' => ($_POST["colors"]) ? implode(",",$_POST["colors"]) : "",
    'opt_powers' => ($_POST["optpwr"]) ? implode(",",$_POST["optpwr"]) : "",
    'axis' => ($_POST["axis"]) ? implode(",",$_POST["axis"]) : "",
    'cylinder' => ($_POST["cylinder"]) ? implode(",",$_POST["cylinder"]) : "",
// другие параметры
    'popular' => $_POST["popular"],
    'time_create' => 0+time(),
    'time_modify' => 0+time()
);
$qstr = MakeInsert($a,$CONFIG['table_market'],"");
// делаем запрос
$res = mysql_query($qstr,$link) or Die("Невозможно добавить товар в БД!<br>[$qstr]");
$new_id = mysql_insert_id() or Die("Невозможно получить id последней записи из БД! <br>[$qstr]");
$msg = "Новый товар в базу добавлен, id = ($new_id)";
echo $msg;
?>
<br>
<input type="button" name="Return_to_market" value="Вернуться к списку товаров" onClick="document.location.href='goods.php';return false;">
<br>
<div style="display:none">
    &nbsp;
</div>





