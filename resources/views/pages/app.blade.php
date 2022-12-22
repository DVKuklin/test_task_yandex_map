<div class="row mt-4">
    <div class="col-3">
        <form action="{{ route('point.create') }}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label">Название точки</label>
                <input type="text" class="form-control" name="name">
            </div>        
            <div class="mb-3">
                <label class="form-label">Широта</label>
                <input type="text" class="form-control" name="latitude" id="newPointLatitude">
            </div>
            <div class="mb-3">
                <label class="form-label">Долгота</label>
                <input type="text" class="form-control" name="longitude" id="newPointLongitude">
            </div>
            <button type="submit" class="btn btn-primary">Добавить точку</button>
        </form>

        <!-- Список локаций -->
        @foreach ($points as $point)

            <div class="card my-3" style="width: 100%;">
                <div class="card-body">
                    <form action=" {{route('point.update') }} " method="post" id="point_form_{{$point->id}}">
                        @csrf
                        <input type="hidden" name="point_id" value="{{$point->id}}">

                        <!-- <input type="hidden" name="point_id" value="{{$point->id}}"> -->

                        <h5 class="card-title" id="point_name_{{$point->id}}">{{$point->name}}</h5>
                        <div id="point_form_name_{{$point->id}}" class="d-none">
                            <input type="text" 
                                    class="form-control" 
                                    name="name" 
                                    value="{{$point->name}}">
                        </div>
                        
                        <p class="card-text">
                            <b>Широта:</b> 
                            <span id="point_latitude_{{$point->id}}">{{$point->latitude}}</span>
                            <input type="text" 
                                    class="form-control d-none" 
                                    name="latitude" 
                                    value="{{$point->latitude}}" 
                                    id="point_form_latitude_{{$point->id}}">
                        </p>
                        <p class="card-text">
                            <b>Долгота:</b> 
                            <span id="point_longitude_{{$point->id}}">{{$point->longitude}}</span>
                            <input type="text" 
                                    class="form-control d-none" 
                                    name="longitude" 
                                    value="{{$point->longitude}}" 
                                    id="point_form_longitude_{{$point->id}}">
                        </p>
                        <button type="button" 
                                class="btn btn-primary m-1" 
                                onclick="pointEdit({{$point->id}})" 
                                id="btn_pointEdit_{{$point->id}}">Редактировать</button>
                        <button type="button" 
                                class="btn btn-primary m-1 d-none" 
                                onclick="pointCancel({{$point->id}})" 
                                id="btn_pointCancel_{{$point->id}}">Отменить</button>
                        <button type="submit" 
                                class="btn btn-warning m-1 d-none" 
                                id="btn_pointSubmit_{{$point->id}}">Применить</button>
                        <button type="button" 
                                class="btn btn-danger m-1"
                                onclick="pointDelete({{$point->id}})">Удалить</button>
                        <button type="button" 
                                class="btn btn-success m-1" 
                                id="btn_goToPoint_{{$point->id}}"
                                onclick="goToPoint({{$point->id}})">Показать на карте</button>
                    </form>
                </div>
            </div>
        @endforeach
<script>
    let points = [
        @foreach ($points as $point)
            {
                name:"{{ $point->name }}",
                latitude:{{ $point->latitude  }},
                longitude:{{ $point->longitude }}
            },
        @endforeach
    ];

</script>
    </div>
    <div class="col-9">
        <div id="map" style="width: 600px; height: 400px"></div>
        <!-- <div>
            <button onclick="setCenter()">Меняем центр</button>
            <button onclick="addPoint()">Новая точка</button>
            <button onclick="getCoor()">Получить координаты</button>
            
        </div> -->
    </div>

</div>






