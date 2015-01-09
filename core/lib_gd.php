<?php
require_once "lib_core.php";
// base64-строка для прозрачной точки 1x1.gif
$emptydot_1x1gif = "R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==";
// base64-строка для плашки "нет изображения" 120х90
$noimg_120x90 = 'R0lGODlheABaALMPAERERIiIiLu7uxEREczMzCIiIu7u7jMzM1VVVZmZmXd3d2ZmZt3d3aqqqgAA';
$noimg_120x90.= 'AP///yH5BAEAAA8ALAAAAAB4AFoAAAT/8MlJq7046827/2AojmRpnmiqrmzrvnAsz3Rt33iu73zv';
$noimg_120x90.= '/8CgcEgsGo/IpHLJbDqf0Kh0Sq1ar9isdsvter/gsHhMLpvPTABgQgAoJAm1OvGQ29EYh2MicKwf';
$noimg_120x90.= 'AXp6AQ+ChngXenx+EoGEFY6IeXsSfX+RkA6PkhV6cgeMgA4FagQTmJwUhoKXhgKnmqmdDgK1ga2b';
$noimg_120x90.= 'sLmyipWhqLqyqpQPlo2jam/Hu6m9xb+Gf6LMwtXW19jZ2tvcddINahIECHoIphIGCwOjDWx2AOdx';
$noimg_120x90.= 'agivFAhuEwZqr23KCgCE2sjxB29CuAdx6Ei4p9BAADvnPPQysI5SgAEA1kkDZUhhH1fH/0CKE2QA';
$noimg_120x90.= '1oFna/oMKPnRkwQAtCb0whQo1gOOgupJtChIXEkDMx0cYCBqJUoLkRQ4QDBBKUyFEkAlMFbAQbuj';
$noimg_120x90.= 'FGDqDEqI4qAHBBwMIKoVhCIGAzhWYDAqqtUJoNoZy0Ro7oOqDZZSCDsgL0C9vqS9jCmB6wOloOoK';
$noimg_120x90.= 'Hayzg6IFtJz9GzDgnLNpzwQVOBcJ8oKRTPWUNDmK8uhnGAEohHlADle2fx+BQhCgamMOevqEJgZT';
$noimg_120x90.= 'rMLLkVQCAGW0pp6xEpTSIQf1AeSqVR0Q9SXoUe9Vy2ASQAU5p1k/0gsRq7SOaNWIzLGCehWI1ILp';
$noimg_120x90.= 'd4UCqPrZV18/txYJrqOp1sdjMH2GibBKDaz3nU0TwRUTZEyBJRpWtmG21ypioVNVAJYYcGFgFZRV';
$noimg_120x90.= 'GE9ilYQJTIR4uJNR4r1EG2RGoYWMHsoIB90yFSi1gH94iXKSMXkZJdxBJgZlUyRsOVCSiY45AFUv';
$noimg_120x90.= '5BwHFQHROaBMZp5wZtMEOSbnwAJhxTQXTEy11EuQPBUQDIOMrcBALRcQIMBp3cQp55x01mnnnXjm';
$noimg_120x90.= 'qeeefPbp55+ABirooIQWauihiCaq6KKMNqpoBAA7';

// base64-строка для плашки "нет изображения" 240х180
$noimg_240x180 = 'R0lGODlh8AC0ALMPAIiIiLu7u0RERBEREe7u7iIiIszMzN3d3TMzM2ZmZqqqqlVVVZmZmXd3dwAA';
$noimg_240x180.= 'AP///yH5BAEAAA8ALAAAAADwALQAAAT/8MlJq7046827/2AojmRpnmiqrmzrvnAsz3Rt33iu73zv';
$noimg_240x180.= '/8CgcEgsGo/IpHLJbDqf0Kh0Sq1ar9isdsvter/gsHhMLpvP6LR6zW673/C4fE6v2+/4vH7P7/v/';
$noimg_240x180.= 'gIGCg4SFhoeIiYqLjI2Oj5CRkpOUlZaXmJmam5ydnp+goaKjpKWmp6ipqqusra6vsLGys7S1tre4';
$noimg_240x180.= 'ubq7vL2+v8DBwsPExcbHyMnKy8zNzs/QVAqUBAHWBxYG1gFnBgANAgMOlAEO5gAWAubjZAwF6+vk';
$noimg_240x180.= '6+gV6uZkCfDrA/Ln6fFiGMBDkABAAAL9HNCjYI9dmHcOBhjIVM5fPYAWqh3ksQ2hBm0b/y0oWMcg';
$noimg_240x180.= 'hDZsGUDGuFalosJ/9yoYaOgggccHAPTBW3ghpwMBFBqs4/bgAAJ9BaZVIABA3LoFE4OuI8BggYAE';
$noimg_240x180.= 'JSvMMwDxZ9QJARI4jcjT588J9oBKaMiTQL51Ar4+cEkUJ0a7ZycINVf3AdOj+tSKcMlz7d0HBsau';
$noimg_240x180.= 'Q+DRrM7CFXwKdumAKGV4SiUQAKwz8wN7BTibW6B1tOKINz/rdNCAwoJ1StNKGDmawmadEsEOnWCW';
$noimg_240x180.= 'gmTduyeIhic4xOXVMTVDHNCggVN6jvVB9m1OsGjLAxYAANCVNNp9AroOuNl1desJ+hDQTMDQAYLt';
$noimg_240x180.= 'Y28ScDpe9dn55upPeG2uIMTJweHlEP9e1sFTF20OFLDdfyQchxx15kQlUIIV0NXBbwLypZl8cE1g';
$noimg_240x180.= 'wGIevfWSBPAsgI1jN8GT1Yf5BfUViw545lJrsu1VGQUw0nPAOihZKEFvvFX3oz51mYWSbCM4uFp7';
$noimg_240x180.= 'NVHAIwU+bvDbAeKM1ZdmZi1kVmYELIaeOQVQIGJmHe73ZDYIFmbWTNXlGBmYTGZF2DYiQggUlREF';
$noimg_240x180.= 'aJZHSA4G13aAcnfXOgUIYGhDfUWpwW/8mdWXPgPw1FBqDX2Z12zzWFpWgAc0UJ5FFACmXnX2IADT';
$noimg_240x180.= 'AIeGY5GSdzF6DqdPWQNYcSAQBtOAyAU4l64ZSEZbAV1qaGl1WRmWnLEOlSmBrSSCKiD/UXjuk+mb';
$noimg_240x180.= '+YE5LZPI0cPqsb6CGeyNEzBwmpBJXvvdsYSmeqhcivZaHUTc6ApoVwtViu25YU6QpqZSRSgBfwgo';
$noimg_240x180.= 'gJC5iK2TQFo2XmkPquoKIKfBgNo75E/wPsArgsQ1SLB9AwLG3gbtYhCdd7xOsFyQ5nCprI0oPZCw';
$noimg_240x180.= 'pR9L0NUETin1bWGAjZcWfgmmtle+GEQJ5MRPNQsuptUFMKvGziIrZn5yHdDysiX3BI9+wU39wMxU';
$noimg_240x180.= 'm8OYBCIu5JJaibU4bFRmeWexOVllCeFLsiEY8wMTOlCsX18J3erVHulKH0J9GrexxEXBUxAA6lwZ';
$noimg_240x180.= 'stXXBsfd4ZyZem5E4RFKabo7OUlc/3l1LQeAiCMWDKd9ajXkWVcCbLdApMAdPXSGCwVYNz2B1zr4';
$noimg_240x180.= 'YXUTWWHVFphVnOPIeXYbbnIhNm6Tmieo09zRsSUcbMaqtWN+N5X9WOtF7k2u0Z2fWfsHzN5bgQLD';
$noimg_240x180.= '2bS7sFKuI1dw4qbnmWZiGa61BAfwByZk85jFegUiCnAz0YLpk+9wZL82YQ9lA1pT8ohSt5h9rwYH';
$noimg_240x180.= 'sEbxbBBBa3BgGxzQyPyMhg6NZCCCG1yBRq4UjI1FowYmPOEMUqjCGLCwhS94IQxnSMMa2vCGOMyh';
$noimg_240x180.= 'DnfIwx768IdADKIQh0jEIhrxiEhMohKXyMQmOvGJUIyiFKdIxSpa8YpYzKIWt8jFLjJ68YtgDKMY';
$noimg_240x180.= 'x0jGMprxjGhMoxrXyMY2uvGNcIyjHOdIxzra8Y54zKMe98jHPvrxj0SMAAA7';

function UploadImage($FILE,$POST)
{
    global $CONFIG;
    global $USERINFO;
    if ($FILE['imagefile']['size']>$CONFIG['MAX_IMAGE_SIZE'])
    {
        $image['msg'].="Размер файла превышает допустимый для изображений, ".$CONFIG['MAX_IMAGE_SIZE']."<br>\n";
        $image['ok'] = 0;
        return $image;
        exit;
    }
    else
    {
        // загрузим изображение (или пошлем нафик)
        switch ($FILE['imagefile']['type'])
        {
            case 'image/jpeg': $img = imageCreateFromJpeg($FILE['imagefile']['tmp_name']) or Die("Не удается загрузить файл"); break;
            case 'image/png': $img = imageCreateFromPng($FILE['imagefile']['tmp_name']) or Die("Не удается загрузить файл"); break;
            case 'image/gif': $img = imagecreatefromgif($FILE['imagefile']['tmp_name']) or Die("Не удается загрузить файл"); break;
            default:
                {
                $image['msg'].="Недопустимый формат файла [<b>".$FILE['imagefile']['type']."</b>]!<br>\n";
                $image['ok']=0;
                return $image;
                exit;
                } break;
        };
        // получаем основные данные, это для базы
        $image_info = getimagesize($FILE['imagefile']['tmp_name']) or Die("Не удается получить размер файла");
        $image['filename'] = $FILE['imagefile']['name'];
        $image['filesize'] = $FILE['imagefile']['size'];
        $image['width'] = ImageSX($img);
        $image['height'] = ImageSY($img);
        $image['mimetype'] = $FILE['imagefile']['type'];

        $image['comment'] = (""==$POST['image_comment']) ? "&nbsp;" : $POST['image_comment'];

        // временное имя файла для превьюшки
        $tempfile_tn  = tempnam('tmp','tn_');
        // делаем превьюшку
        $image_tn = imageCreateTrueColor($CONFIG['PREVIEW_WIDTH'],$CONFIG['PREVIEW_HEIGHT']); // забьем пока на неквадратные изображения, это нужны поля в базе
        imageCopyReSampled($image_tn,$img,0,0,0,0,$CONFIG['PREVIEW_WIDTH'],$CONFIG['PREVIEW_HEIGHT'],$image['width'],$image['height']);

        $tc = imageColorAllocate($image_tn,255,255,255);
        imageColorTransparent($image_tn, $tc);

        imageGIF($image_tn, $tempfile_tn) or Die("Не удается сохранить временный файл препросмотра!"); // это мы выгрузили превью во временный файл
        imagedestroy($image_tn); // удаляем превью чтобы не было утечек.
        // теперь загрузим в $image['previe'], который типа blob, тип файла у нас GIF
        $f_tn_size = filesize($tempfile_tn);
        $image['preview_size'] = $f_tn_size;
        $f_tn = fopen($tempfile_tn,"rb") or Die("Не удается открыть временный файл препросмотра!");
        $image['preview'] = fread($f_tn,$f_tn_size);
        fclose($f_tn);
        // сконвертим файл и загрузим в $image['image']
//    if ($FILE['imagefile']['type']!=='image/jpeg')
        {
            // нужно сконвертить в JPEG и снова загрузить в $img;
            $tempfile_img = tempnam('tmp', 'jpg_');
            // в $img у нас лежит картинка
            imagejpeg($img,$tempfile_img,80);
            // теперь загрузим
            $image['filesize'] = filesize($tempfile_img);
            $f_img = fopen($tempfile_img,"rb") or Die("Не удается открыть временный файл JPG");
            $image['image'] = fread($f_img, $image['filesize']) or Die("Не удается прочитать содержимое временного файла JPG");
            fclose($f_img) or Die("Не удается закрыть временный файл JPG");
            $image['msg'].= "Файл преобразован в формат JPG<br>\n";
            $image['ok'] = 1;
        }
        // кусим, все равно преобразуем с 60% сжатием
        /* else
        {
          $f_img = fopen($FILE['imagefile']['tmp_name'],"rb") or Die("Не удается открыть файл JPG");
          $image['filesize'] = filesize($FILE['imagefile']['tmp_name']);
          $image['image'] = fread($f_img, $image['filesize']) or Die("Не удается прочитать содержимое файла JPG");
          fclose($f_img) or Die("Не удается закрыть временный файл JPG");
          $image['msg'].= "Файл загружен в исходном формате JPG<br>\n";
          $image['ok'] = 1;
        } */
    }
    imagedestroy($img);
    $image['add_user'] = $USERINFO['current_user'];
    return $image;
};

// функция добавляет данные в базу, возвращает id нового изображения
function AddImageToDB($data)
{
    global $CONFIG;
    if (0===$data['ok']) exit;
    $image = $data;
    $link = ConnectDB();
    $image['preview'] = mysql_real_escape_string($image['preview']);
    $image['image'] = mysql_real_escape_string($image['image']);
    $image['add_date'] = time();
    $q = "INSERT INTO ".$CONFIG['table_images']." (filename, filesize, height, width, add_user, comment, add_date, preview_size)";
    $q = $q."VALUES(";
    $q = $q."'".$image['filename']."',";
    $q = $q."'".$image['filesize']."',";
    $q = $q."'".$image['height']."',";
    $q = $q."'".$image['width']."',";
    $q = $q."'".$image['add_user']."',";
    $q = $q."'".$image['comment']."',";
    $q = $q."'".$image['add_date']."',";
    $q = $q."'".$image['preview_size']."')";
    $res = mysql_query($q,$link) or Die("Невозможно выполнить первичную вставку данных в БД!".$q);
    $new_id = mysql_insert_id($link) or Die("Невозможно получить id последней записи из БД!");
    $q = "UPDATE imagelist SET preview='".$image['preview']."' WHERE id=$new_id";
    $res = mysql_query($q,$link) or Die("Невозможно выполнить вставить препросмотр в БД! Размер данных = ".strlen($image['preview']));
    // ErrorReport("Невозможно выполнить вставить препросмотр в БД! Размер данных = ".strlen($image['preview']),$image['preview']);
    $q = "UPDATE imagelist SET image='".$image['image']."' WHERE id=$new_id";
    $res = mysql_query($q,$link) or Die("Невозможно выполнить вставить изображение в БД! Размер данных = ".strlen($image['image']));
    //ErrorReport("Невозможно выполнить вставить изображение в БД! Размер данных = ".strlen($image['image']),$image['image']);
    $result['msg'] = 'Размер изображения в базе = '.strlen($image['image']);
    $result['ok'] = 1;
    $result['id'] = $new_id;
    CloseDB($link);
    return $result;
}

function LoadGallery()
{
    unset($imgs);
    global $CONFIG;
    $link = ConnectDB();
    $q = "SELECT * FROM ".$CONFIG['table_images']." ORDER BY id";
    $result = mysql_query($q) or Die("Невозможно получить изображения из базы данных");
    $num_images = mysql_num_rows($result);
    for ($i=0;$i<$num_images;$i++)
    {
        $one_image = mysql_fetch_assoc($result);
        $one_image["add_date"] = date("d/M/Y H:i:s",$one_image["add_date"]);
        $imgs[]=$one_image;
    }
    CloseDB($link);
    return $imgs;
}

function LoadImageInfo($id)
{
    unset($one_image);
    global $CONFIG;
    $link = ConnectDB();
    $q = "SELECT * FROM ".$CONFIG['table_images']." WHERE (id=$id)";
    $result = mysql_query($q) or Die("Невозможно получить изображения из базы данных");
    $one_image = mysql_fetch_assoc($result);
//    $one_image["add_date"] = date("d/M/Y H:i:s",$one_image["add_date"]);
    CloseDB($link);
    return $one_image;
}

?>