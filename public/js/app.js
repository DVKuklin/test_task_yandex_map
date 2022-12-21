ymaps.ready(init);
function init(){
    var myMap = new ymaps.Map("map", {
        center: [57.76, 47.64],
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

}

function pointDelete(point_id) {
    if (confirm('Вы действительно хотите удалить точку?')) {
        $('#point_form_'+point_id).attr("action","/point/delete");
        $('#point_form_'+point_id).submit();
    }

}