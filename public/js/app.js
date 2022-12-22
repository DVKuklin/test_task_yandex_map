var myMap;

// Дождёмся загрузки API и готовности DOM.
ymaps.ready(init);

function init () {
    // Создание экземпляра карты и его привязка к контейнеру с
    // заданным id ("map").
    myMap = new ymaps.Map('map', {
        // При инициализации карты обязательно нужно указать
        // её центр и коэффициент масштабирования.
        center: [55.76, 37.64], // Москва
        zoom: 15
    }, {
        searchControlProvider: 'yandex#search'
    });

    
    myMap.events.add('click', function (e) {
        // Получение координат щелчка
        var coords = e.get('coords');

        $('#newPointLatitude').val(coords[0]);
        $('#newPointLongitude').val(coords[1]);
    });

    let location = ymaps.geolocation.get();
    
    location.then(
        function(result) {
            myMap.setCenter(result.geoObjects.position);
            myMap.geoObjects.add(new ymaps.Placemark(
                    result.geoObjects.position, 
                    {
                        balloonContent: 'Ваше текущее местоположение',
                        hintContent: "Текущее положение"
                    }
            ));
        },
        function(err) {
            alert('Ошибка обнаружения Вашего место положения: ' + err);
        }


    );

    //Отмечаем точки на карте
    points.forEach(point => {
        myMap.geoObjects.add(new ymaps.Placemark(
            [point.latitude,point.longitude], 
            {
                balloonContent: point.name,
                hintContent: point.name
            }
        ));
    });


}

function getCoor() {
    console.log(myMap.getCenter());
}

let coor = {
    x:55.782392,
    y:37.614924
}

function setCenter() {
    myMap.setCenter([coor.x, coor.y]);
}

function addPoint() {
    myMap.geoObjects
    .add(new ymaps.Placemark([coor.x, coor.y], {
        balloonContent: 'Новая точка',
        balloonContentHeader: "Балун метки",
        balloonContentBody: "Содержимое <em>балуна</em> метки",
        balloonContentFooter: "Подвал",
        hintContent: "Мой хинт метки"
    }));
}

function pointEdit(point_id) {
    $('#point_name_'+point_id).addClass('d-none');
    $('#point_form_name_'+point_id).removeClass('d-none');
    $('#point_latitude_'+point_id).addClass('d-none');
    $('#point_form_latitude_'+point_id).removeClass('d-none');
    $('#point_longitude_'+point_id).addClass('d-none');
    $('#point_form_longitude_'+point_id).removeClass('d-none');
    $('#btn_pointEdit_'+point_id).addClass('d-none');
    $('#btn_pointCancel_'+point_id).removeClass('d-none');
    $('#btn_pointSubmit_'+point_id).removeClass('d-none');
    $('#btn_goToPoint_'+point_id).addClass('d-none');

    $('#point_form_name_'+point_id+' input').val($('#point_name_'+point_id).html());
    $('#point_form_latitude_'+point_id).val($('#point_latitude_'+point_id).html());
    $('#point_form_longitude_'+point_id).val($('#point_longitude_'+point_id).html());
}

function pointCancel(point_id) {
    $('#point_name_'+point_id).removeClass('d-none');
    $('#point_form_name_'+point_id).addClass('d-none');
    $('#point_latitude_'+point_id).removeClass('d-none');
    $('#point_form_latitude_'+point_id).addClass('d-none');
    $('#point_longitude_'+point_id).removeClass('d-none');
    $('#point_form_longitude_'+point_id).addClass('d-none');
    $('#btn_pointEdit_'+point_id).removeClass('d-none');
    $('#btn_pointCancel_'+point_id).addClass('d-none');
    $('#btn_pointSubmit_'+point_id).addClass('d-none');
    $('#btn_goToPoint_'+point_id).removeClass('d-none');
}

function pointDelete(point_id) {
    if (confirm('Вы действительно хотите удалить точку?')) {
        $('#point_form_'+point_id).attr("action","/point/delete");
        $('#point_form_'+point_id).submit();
    }

}

function goToPoint(point_id){
    let coords = [
        $('#point_latitude_'+point_id).html(),
        $('#point_longitude_'+point_id).html()
    ]

    myMap.setCenter(coords);

    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });

}