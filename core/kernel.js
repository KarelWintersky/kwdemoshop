var link_to_img_prompt = "Копирование прямой ссылки на это изображение, для сохранения в буфере обмена \n и вставки в другой документ";
var link_to_article_prompt = "Копирование прямой ссылки на статью, для сохранения в буфере обмена \n и вставки в другой документ";
var link_to_offer_prompt = "Копирование прямой ссылки на рекламную акцию, для сохранения в буфере обмена \n и вставки в другой документ";

var show_img_url = "image_show.php?id=";
var show_pre_url = "image_preview.php?id=";
var show_article_url = "index.php?action=article&id=";
var show_offer_url = "core/offer_show.php?id=";

/*--------------------------------------------*/
// Link to a image
/*--------------------------------------------*/

function link_to_image(pid)
{
    temp = prompt(link_to_img_prompt, show_img_url+pid);
    return false;
}

/*--------------------------------------------*/
// Link to a article
/*--------------------------------------------*/

function link_to_article(pid)
{
    temp = prompt(link_to_article_prompt, show_article_url+pid);
    return false;
}

function link_to_offer(pid)
{
    temp = prompt(link_to_offer_prompt, show_offer_url+pid);
}

/*--------------------------------------------*/
// Обслуживание окон
/*--------------------------------------------*/

function open_msg(win_file, win_title)
{
    window.open(win_file, win_title, 'resizable=no,width=500,height=480,toolbar=no,scrollbars=no,location=no,menubar=no,status=no');
}

function open_pwin(win_file, win_title)
{
    window.open(win_file, win_title, 'resizable=yes,width=540,height=560,toolbar=no,location=yes,menubar=no,status=no');
}

/*--------------------------------------------*/
// AJAX функции
/*--------------------------------------------*/

function makeRequest(url,control) {
    var httpRequest = false;

    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) {
            httpRequest.overrideMimeType('text/xml');
        }
    } else if (window.ActiveXObject) { // IE
        try {
            httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }

    if (!httpRequest) {
        alert('Не вышло :( Невозможно создать экземпляр класса XMLHTTP ');
        return false;
    }
    httpRequest.onreadystatechange = function() { alertContents(httpRequest,control); };
    httpRequest.open('GET', url, true);
    httpRequest.send(null);
}

function alertContents(httpRequest,control) {

    if (httpRequest.readyState == 4) {
        if (httpRequest.status == 200) {
            control.innerHTML = httpRequest.responseText;
        } else {
            alert('С запросом возникла проблема.'+httpRequest.url);
        }
    }

}

function UpdateImageInfo(id,target_div)
{
    var id = document.getElementById("image_id").value;
    var cmt = document.getElementById("comment").value;
    var trg = document.getElementById(target_div);
    req = "?action=ajax_update&id="+id+"&comment="+cmt;
    makeRequest("image.php" + req,trg);
}

// AJAX: очистить указанный div
function clearDiv(id) {
    document.getElementById(id).innerHTML = "";
}

// AJAX: вывести контент скриптом show_content в указанный DIV
function showContent(id,did) {
    req = "?id=" + id;
    makeRequest("show_content.php" + req,document.getElementById(did));
}

// AJAX: вывести результат работы указанного скрипта в указанный DIV
function showAnyFile(url,did) {
    req = url;
    makeRequest(req,document.getElementById(did));
    return false;
}

// AJAX: скрыть указанный DIV
function hide_div(id) {
    var did = document.getElementById(id);
    did.style.display='none';
}

// AJAX: показать указанный DIV
function show_div(id) {
    var did = document.getElementById(id);
    did.style.display='block';
}

function _InvertDisabledState(did) {
    did.style.display = (did.style.display=="block") ? "none" : "block";
}

// закрывает себя и обновляет родителя
function RefreshAndClose()  {
    opener.location.reload();
    window.close();
}

// -- функции неизвестного назначения, унаследованные из предыдущих редакций
// -- актуальность неизвестна, возможно не используются

function rcolor(id, color) {
    var rid = document.getElementById(id);
    rid.style.color=color;
    if (color=='#fff') setTimeout('rcolor("'+id+'", "#999")', 1000);
}

function showEditor(id,did) {
    req = "?is_content=" + id;
    makeRequest("show_editor.php" + req,document.getElementById(did));
}


/* функция валидации формы на основе title="required" */
function CheckForm(fobj) {
    var  ft  = "";
    var  fv  = "";
    var  fn  = "";
    var  els = "";
    var i;
    for(i=0; i<fobj.elements.length;i++)
    {
        elem  =  fobj.elements[i];  //  текущий  элемент
        ft  =  elem.title;  //  title  элемента
        fv  =  elem.value;  //  value  элемента
        fn  =  elem.name;  //  name  элемента
        if (encodeURI(ft)=="required"&& encodeURI(fv).length<1)
        {
            alert('"'+fn+'"  is  a  required  field,  please  complete.');
            elem.focus();
            return  false;
        } // if
    }  //  for
}

/* функция добавления в избранное */
/* © http://www.manhunter.ru/webmaster/43_krossbrauzernoe_dobavlenie_stranici_v_zakladki.html */
/* использование:

 <a href="#" onclick="return add_favorite(this);">Добавить в Избранное</a>

 */
function add_favorite(a) {
    title=document.title;
    url=document.location;
    try {
        // Internet Explorer
        window.external.AddFavorite(url, title);
    }
    catch (e) {
        try {
            // Mozilla
            window.sidebar.addPanel(title, url, "");
        }
        catch (e) {
            // Opera
            if (typeof(opera)=="object") {
                a.rel="sidebar";
                a.title=title;
                a.url=url;
                return true;
            }
            else {
                // Unknown
                alert('Я не могу опознать ваш браузер. :( Нажмите Ctrl-D для добавления страницы в закладки');
            }
        }
    }
    return false;
}

/* Работа с таблицами... тестировалось в мозилле */
/* Вызов: для ячейки onClick="destroy_row(this)"    */

function destroy_row(cell) {
    cell.parentNode.parentNode.removeChild(cell.parentNode);
}

/* Если будешь вызывать для tr а не td, то соответственно убираешь по одному parentNode: */

function destroy_row(row) {
    row.parentNode.removeChild(row);
}

/* Вообще говоря, второй вариант функции убивает любой элемент который ему передали в параметрах.
 Кстати, если уж на то пошло, то логичнее всего сделать так: */

function destroy_this(el) {
    el.parentNode.removeChild(el);
}

/* И если нужно убивать строку по клику на ячейку, то юзать:
 <td onClick="destroy_this(this.parentNode)">

 Естественно, как обычно тестировалось только в мазиле, но вдруг... :)

 PS: А есть еще метод appendChild()... :)                              */
