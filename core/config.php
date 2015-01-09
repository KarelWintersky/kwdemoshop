<?php
// define constants
// highslide
define("MAXINT",2147483647,1);

// КОМУ ОТСЫЛАЕМ ИЗ МЕНЕДЖЕРОВ
$CONFIG['manager_email'][1] = "ishop2008@rambler.ru";
$CONFIG['manager_email'][2] = "ishop@newglance.ru";
$CONFIG['resume_email'] = 'info@newglance.ru';
$CONFIG['faq_email'] =  'info@newglance.ru';
$CONFIG['control_email'] = "arris_icq@mail.ru";

// FIX_01: вообще это и прочие переменные конфига надо хранить в таблице config

// define config variables
$CONFIG['MAX_IMAGE_SIZE']  = 2000000;

$CONFIG['PREVIEW_WIDTH']   = 120;
$CONFIG['PREVIEW_HEIGHT']  = 90;

$CONFIG['time_format']     = "d/M/Y H:i:s";
$CONFIG['time_format_date']= "%d %B %Y";

$CONFIG['username_local'] 	= 'root';
$CONFIG['username_remote']	= 'arris';

$CONFIG['host_local']    	= 'localhost';
$CONFIG['host_remote']   	= 'localhost';

$CONFIG['password_local']	= '';
$CONFIG['password_remote']	= 'Nopa$$word1sset';

$CONFIG['database_local']       = 'demoshop';
$CONFIG['database_remote']       = 'demoshop';

$CONFIG['table_users']	  = 'userlist';
$CONFIG['table_images'] = 'imagelist';
$CONFIG['table_market'] = 'market';
$CONFIG['table_backlog'] = 'backlog'; // таблица заказов
$CONFIG['table_articles'] = 'articles';
$CONFIG['table_offers'] = 'offerslist'; // таблица новостей
$CONFIG['table_faq'] = 'faq'; // таблица ЧАВО (онлайн консультация)

$CONFIG['url_showimg'] = 'image_show.php?id=';
$CONFIG['url_showtn'] = 'image_preview.php?id=';

$CONFIG['default_currency'] = "RU";

$CONFIG['currency_list'][0] = "RU";
$CURRENCY['RU']['prefix'] = ""; // значок рублей или буквы
$CURRENCY['RU']['hi'] = "руб.";
$CURRENCY['RU']['lo'] = "коп.";


/*
$CONFIG['currency_list'][1] = "EU";
$CURRENCY['EU']['prefix'] = "EU "; // значок рублей или буквы
$CURRENCY['EU']['hi'] = "евро";
$CURRENCY['EU']['lo'] = "центов";

$CONFIG['currency_list'][2] = "US";
$CURRENCY['US']['prefix'] = 'US '; // значок рублей или буквы
$CURRENCY['US']['hi'] = "долларов";
$CURRENCY['US']['lo'] = "центов";
*/

$CONFIG['link_to_img_prompt'] = "Копирование прямой ссылки на это изображение, для сохранения в буфере обмена и вставки в другой документ";

$CONFIG['usergroups'][0] = "Гости";
$CONFIG['usergroups'][1] = "Покупатели";
$CONFIG['usergroups'][2] = "Лучшие покупатели";
$CONFIG['usergroups'][3] = "VIP";
$CONFIG['usergroups'][4] = "Менеджеры";
$CONFIG['usergroups'][9] = "Администратор";
$CONFIG['usergroups'][1000] = "Системный оператор";

?>