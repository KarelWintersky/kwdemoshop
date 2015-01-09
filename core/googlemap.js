function GMapInit()
{
    // Инициализация класса Google Maps и расположение карты в слое GMapContainer
    var map = new GMap2(document.getElementById("GMapContainer"));
    // Задаем настройки вывода
    map.setCenter(new GLatLng(59.9694553,30.2613394), 9); 	// Широта, долгота и коэффициент увеличения центра (обязательный параметр)
    map.addControl(new GLargeMapControl()); // Добавляем на карту Google Maps управление прокруткой и приближением
    // 	map.addControl(new GMapTypeControl());  // Добавляем на карту Google Maps возможность выбрать тип отображения (карта, вид со спутника, комбинированный режим)
    map.enableScrollWheelZoom(); // Масштабирование карты скроллингом
}

function CenterMapEmpty(x,y,comment,range)
{

    GUnload();
    var map = new GMap2(document.getElementById("GMapContainer"));
    map.setCenter(new GLatLng(x, y), range);
}

function CenterMap(x,y,comment,range)
{

    GUnload();
    var map = new GMap2(document.getElementById("GMapContainer"));
    map.setCenter(new GLatLng(x, y), range);
    map.enableScrollWheelZoom(); // Масштабирование карты скроллингом
    map.addOverlay(createMarker(x,y,comment));
}

function createMarker(x, y, comment)
{
    // Создаем точку на карте с координатами x и y
    var point = new GLatLng(x, y);
    // Создаем маркер в указанной точке
    var marker = new GMarker(point);
    // Добавляем обработчик события нажатия на маркер
    if (comment != '-')
    {
        // При нажатии открывается информационное окно с заданным текстом
        GEvent.addListener(marker, "click", function() { marker.openInfoWindowHtml(comment);});
    }
    return marker;
}