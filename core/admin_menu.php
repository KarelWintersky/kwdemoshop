<?php   if (!$_SESSION['is_admin']) header("Location: ../index.php");
// LogSessionInfo("../.logs/admin_access_session.txt");
?>

<div class="head">Выберите режим работы</div>
<ul>
    <li><a href="admin.php">Начало</a></li>
    <li>РЕДАКТИРОВАТЬ: </li>
    <li><a href="articles.php">Статьи</a></li>
    <li><a href="offers.php">Рекламные акции</a></li>
    <li><a href="faq.php">Мини-консультации</a></li>
    <li><a href="goods.php">Товары</a></li>

    <hr width="80%" align="left">
    <li>СТАТИСТИКА</li>
    <!--  <li><a href="_statsales.php">Статистика</a></li> -->
    <li><a href="backlog.php">Текущие заказы</a></li>
    <hr width="80%" align="left">
    <li><a href="dispatch.php">Рассылка сообщений</a></li>
    <hr width="80%" align="left">
    <li style="color:red"><b>Справочники:</b></li>
    <li>Поля отбора товара:<br><small>Будьте осторожны с этими полями</small>
    <li><a href="ref_list.php?name=ref_producttype">Тип товара</a></li>
    <li><a href="ref_list.php?name=ref_producer">Фирма-производитель</a></li>
    <!--  <li><a href="ref_list.php?name=ref_dou">Длительности использования</a></li> -->
    <li><a href="ref_list.php?name=ref_mow">Режимы ношения</a></li>
    <li><a href="ref_list.php?name=ref_chroma">Цветность</a></li>
    <hr width="80%" align="left">
    <li><a href="ref_list.php?name=ref_colors">Цвет</a></li>
    <li><a href="ref_list.php?name=ref_basecurve">Базовая кривизна</a></li>
    <li><a href="ref_list.php?name=ref_opticpower">Оптическая сила (<b>Sph</b>)</a></li>
    <li>Для астигматических линз:</li>
    <li><a href="ref_list.php?name=ref_cylinder">Цилиндр (<b>Cyl</b>)</a></li>
    <li><a href="ref_list.php?name=ref_axis">Оптическая ось (<b>Ax</b>)</a></li>

    <hr width="80%" align="left">
    <li>Другие справочники:</li>
    <li><a href="ref_list.php?name=ref_articlerelations">Семейства статей</a></li>

    <hr width="80%" align="left">
    <li>Дополнительно:</li>
    <li><a href="images.php">Изображения продукции</a></li>

    <br><br>
    <li><a href="../index.php">Выход из админ-панели</a></li>
</ul>






