<?php
//goods_update
  require_once "lib_shop.php";
  unset($goods);
  $id = $_POST['id'];
  // загрузим старую версию товара
  $goods = LoadGoods($_GET['id']);
  // начнем её обновлять согласно актуальной информации из $_POST
  // название и описание
  $goods = array (
    'title' => $_POST["GoodsName"],
    'description' => stripcslashes($_POST["GoodsDescription"]),
    'short_info' => mysql_escape_string($_POST["short_info"]),
    'popular' => $_POST["popular"],
    'time_modify' => time(),
  // теперь разберемся с айди превью и картинки
    'image_id' => $_POST["image_id"],
    'preview_id' => $_POST["image_id"],
  // теперь обработаем цены.
    'price_box' => 0 + $_POST["price_box_ru_hi"]*100 + $_POST["price_box_ru_lo"],
  // обработаем остальные поля
// параметры из строк
    'humidity' => $_POST['humidity'],
    'diameter' => $_POST['diameter'],
    'lenses_in_box' => $_POST["lenses_in_box"],
    'feature' => $_POST["feature"],
    'popular' => $_POST["popular"],
// параметры из селектов
    'producer' => $_POST['producer'],
//    'dou' => $_POST['dou'], // не хочет заказчик длительности использования
    'mow' => $_POST['mow'],
    'chroma' => $_POST['chroma'],
    'type' => $_POST['producttype']
  );
// параметры из чебоксов
  If (IsSet($_POST["basecurves"])) $goods['basecurves']=implode(",",$_POST["basecurves"]);
  else $goods['basecurves']='';
  If (IsSet($_POST["optpwr"])) $goods['opt_powers']=implode(",",$_POST["optpwr"]);
  else $goods['opt_powers']='';
  If (IsSet($_POST["colors"])) $goods['colors']=implode(",",$_POST["colors"]);
  else $goods['colors']='';
  If (IsSet($_POST["axis"])) $goods['axis']=implode(",",$_POST["axis"]);
  else $goods['axis']='';
  If (IsSet($_POST["cylinder"])) $goods['cylinder']=implode(",",$_POST["cylinder"]);
  else $goods['cylinder']='';

  // пошла вставка
  $link = ConnectDB();
  $qs = MakeUpdate($goods,$CONFIG['table_market']," WHERE (id=$id) ");
  $res = mysql_query($qs,$link) or Die("Невозможно обновить товар в БД! [$q]");
  $goods['msg'] = "Товар с номером $id обновлен.";
  print_r($goods['msg']);
  // можно напечатать, что мы успешно обработали результат
?>
<input type="button" name="Return_to_market" value="Вернуться к списку товаров" onClick="document.location.href='goods.php'" /><br>

<?php
echo "<!-- ";
//print_r($goods);
echo "-->";
?>

