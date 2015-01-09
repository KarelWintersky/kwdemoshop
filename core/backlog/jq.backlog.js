function UpdateStatFields(data){
    $("#today_date").html(data['date']);
    $("#today_time").html(data['time']);
    $("#orders_count").html(data['size']);
    delta = data['maxtime'];
    delta_h = delta / 60;
    delta_m = delta % 60;
    message = '';
    if (delta_h>0) message = Math.floor(delta_h) + ' час(ов) ';
    message += (delta_m + ' минут');
    $("#delta_time").html(message);
}
function ReloadStatData(message)
{
    $.getJSON('backlog/get.backlog.info.php',function(json){
        UpdateStatFields(json);
        $.jGrowl(message);
        $("#content").load('backlog/backlog.current.list.php');
    });
}

$(document).ready(function(){
    //
    $.jGrowl.defaults.pool = 3;
    // onload
    ReloadStatData("Информация об очереди заказов загружена");
    time_counter = 0;
    time_interval = 60000;
    _reload_enabled = true;
    window.setInterval(function(){
        time_counter++;
        if (_reload_enabled) ReloadStatData("Обновление информации об очереди заказов");
    },time_interval);

    $("#console_reload").click(function(){
        ReloadStatData("Информация об очереди заказов обновлена");
    });

    $(".b_orderwork").live('click',function(){
        this_id = $(this).attr("id");
        $("div.jGrowl-notification").trigger("jGrowl.close"); // закрытие всех сообщений jGROWL
        _reload_enabled = false;
        $("#modal_orderwork").load("backlog/backlog.order.show.php?id="+this_id,function(){
            $('#modal_orderwork').dialog('open');
        });
    }).live('mouseover',function(){ $(this).addClass("ui-state-hover"); })
        .live('mouseout',function(){	$(this).removeClass("ui-state-hover");});;

    $(".b_delivered").live('click',function(){
        this_id = $(this).attr("id");
        // jAlert('Нажата кнопка подтверждения доставки: '+this_id,'Модальное окно');
        jAlert('Так это не работает');
    });

    $(".b_deleteit").live('click',function(){
        this_id = $(this).attr("id");
        jAlert('Так это не работает');
        jConfirm('Удалить заказ?', 'Внимание!', function(r) {
            if (r) jAlert('Заказ №: ' + this_id + 'удален', 'Внимание!');
            else jAlert('Удаление отменено', 'Внимание!');
        });
    }).live('mouseover',function(){ $(this).addClass("ui-state-hover"); })
        .live('mouseout',function(){	$(this).removeClass("ui-state-hover");});

    // определения всяких кнопок в хедере бэклога
    $("#b_quitbacklog").click(function(){ document.location.href="admin.php"; });
    $("#b_gotosite").click(function() { jAlert('Для реализации требуется нормальный хостинг', 'Внимание!'); }); // должно открываться в новой вкладке
    $("#b_fullbacklog").click(function() {
        $("#content").load('backlog/backlog.finished.list.php');
    });
    /* модальное окно */
    $("#modal_orderwork").dialog({
        bgiframe: true,
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 950,
        height: 700,
        buttons: { 'Закрыть': function() { $(this).dialog('close'); } },
        open: function() { },
        close: function() { _reload_enabled = true; }
    });
    /* модальное окно мейлера*/
    $("#modal_mailer").dialog({
        bgiframe: true,
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 650,
        height: 450,
        buttons:
        {
            'Отменить' : function() { $(this).dialog('close'); },
            'Послать' : function() { jAlert('Что-то послали'); $(this).dialog('close'); }
        },
        open: function() { },
        close: function() { }
    });
    /* модальное окно мейлера*/
    $("#modal_productinfo").dialog({
        bgiframe: true,
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 850,
        height: 650,
        buttons:
        {
            'Отменить' : function() { $(this).dialog('close'); }
        },
        open: function() { },
        close: function() { }
    });


    /* привязки к кнопкам в модальном окне #modal_orderwork */
    // Дозаказ
    // в админке NEWGLANCE не существует
    $(".b_ow_reorder").live('click',function(){
        jConfirm('Дозаказать товар? Да/Нет','Внимание', function() {
            // дозаказ товара
        });
    });
    //
    $(".b_ow_productinfo").live('click',function() {
        this_id = $(this).attr("id");
        $('#modal_productinfo').load('backlog/hs_order_info.php?id='+this_id,function(){
            $('#modal_productinfo').dialog('open');
        });
    });

    // Послать письмо клиенту - адрес (из инфы, id то мы получили), тема, текст, кнопка послать или отмена
    $(".b_ow_clientmail").live('click',function(){
        this_id = $(this).attr("id");
        // $.getJSON('backlog/backlog.init.mailer.php', { id: this_id} ,function(json){
        // заполнить поля данных из json
        $('#modal_mailer').empty().html('Функция временно недоступна').dialog('open');
        // });
    });
    $(".b_ow_cancelorder").live('click',function(){
        jConfirm('Отменить заказ? ','Внимание!',function(answer){
            if (answer) jAlert('Заказ отменен (в NEWGLANCE функция не реализована)');
            // тут надо убрать заказ (поставив, например, статус = 100 )
            // потом закрыть модальное окно
            // и обновить список
        });
    });
    // эту кнопку нажимают на складе либо по звонку курьера
    $(".b_ow_deliveryconfirm").live('click',function(){
        this_id = $(this).attr("id");
        jConfirm('Подтвердить доставку? ','Внимание!',function(answer){
            if (answer) {
                // сходим к базе, поставим значения
                $.getJSON('backlog/backlog.confirm.delivery.php',
                    { id: this_id }, function(json){
                        if (json['updated']) $("#mow_time_delivery").html(json['date']);
                        else jAlert('Товар уже доставлен!','Ошибка!');
                    });
            }
        });
    });
    // а эту при финализации обработки
    $(".b_ow_finite").live('click',function(){
        this_id = $(this).attr("id");
        jConfirm('Действительно завершить работу с заказом? ','Внимание!',function(answer){
            if (answer)
                $.getJSON('backlog/backlog.confirm.final.php',{ id: this_id }, function(json){
                    $('#modal_orderwork').dialog('close');
                    // reload
                    ReloadStatData("Обработка заказа завершена. Информация о заказе перенесена в историю заказов");
                });
        });
    });
    $(".b_ow_commentupdate").live('click',function(){
        this_id = $(this).attr("id"); // order_id
        // обновить комментарий (post-запрос) и сообщить об этом
        $(".status_comment").css('display','block').html('Что-то обновили'); // а как убрать её через 5 секунд?
    });

});
