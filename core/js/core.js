/* Привязывает стили и действия к элементу "scroll to top" */
function bindScrollTopAction(target)
{
    $(target).css('float','right').attr('title', 'Наверх').on('click', function(){
        $('html, body').animate({scrollTop:0}, 'slow');
        return false;
    });
}

/* php strpos() аналог.
 * Параметры: (стог сена, иголка, смещение поиска) */
function strpos (haystack, needle, offset) {
    var i = (haystack+'').indexOf(needle, (offset || 0));
    return i === -1 ? false : i;
}

/* прототипные функции trim */
String.prototype.trim = String.prototype.trim || function(){return this.replace(/^\s+|\s+$/g, ''); };
String.prototype.ltrim = String.prototype.ltrim || function(){return this.replace(/^\s+/,''); };
String.prototype.rtrim = String.prototype.rtrim || function(){return this.replace(/\s+$/,''); };
String.prototype.fulltrim = String.prototype.fulltrim || function(){return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,'').replace(/\s+/g,' ');};

// найти в объекте (контейнере инпутов) инпут с именем name и занести в него data
function SetNamedField(obj, name, data)
{
    obj.find("input[name='"+ name +"']").val( data );
}

function preloadOptionsList(url) // Загружает данные (кэширование)
{
    var ret;
    $.ajax({
        url: url,
        async: false,
        cache: false,
        type: 'GET',
        success: function(data){
            ret = $.parseJSON(data);
        }
    });
    return ret;
}

// формирует SELECTOR/OPTIONS list с текущим элементом равным [currentid]
// target - ИМЯ селектора
function BuildSelector(target, data, currentid) // currentid is 1 for NEW
{
    if (data['error'] == 0) {
        var _target = "select[name='"+target+"']";
        $.each(data['data'], function(id, value){
            $(_target).append('<option value="'+id+'">'+value+'</option>');
        });
        var _currentid = (typeof currentid != 'undefined') ? currentid : 1;
        $("select[name="+target+"] option[value="+ _currentid +"]").prop("selected",true);
    } else {
        $("select[name="+target+"]").prop('disabled',true);
    }
}

function strpos (haystack, needle, offset) {
    var i = (haystack+'').indexOf(needle, (offset || 0));
    return i === -1 ? false : i;
}

/* Привязывает стили и действия к элементу "scroll to top" */
function bindScrollTopAction(target)
{
    $(target).css('float','right').attr('title', 'Наверх').on('click', function(){
        // window.scroll(0,0);
        $('html, body').animate({scrollTop:0}, 'slow');
        return false;
    });
}