@extends('templates.main_template')

@section('title')Авторизация || Яндекс карты@endsection

@section('content')

<div class="container-sm">
    <h3 class="text-center">Авторизация</h3>

    <form action="{{ route('auth.login')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почтовый адрес</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Авторизоваться</button>
    </form>

</div>

@endsection