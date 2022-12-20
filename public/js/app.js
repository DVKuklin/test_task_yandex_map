ymaps.ready(init);
function init(){
    var myMap = new ymaps.Map("map", {
        center: [55.76, 37.64],
        zoom: 15
    });

    //Перемещение карты на точку, где находится пользователь
    //И создание балуна
    var location = ymaps.geolocation.get();
    
    location.then(
        function(result) {
            myMap.setCenter(result.geoObjects.position);
            myMap.geoObjects.add(new ymaps.Placemark(
                    result.geoObjects.position, {
                    balloonContent: 'Ваше текущее местоположение'
                }
            ));
        },
        function(err) {
            console.log('Ошибка: ' + err);
        }
    );

}