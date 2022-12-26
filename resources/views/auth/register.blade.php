@extends('templates.main_template')

@section('title')Регистрация || Яндекс карты@endsection

@section('content')

<div class="container-sm">
    <h3 class="text-center">Регистрация</h3>

    <form action="{{ route('auth.register')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Имя</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почтовый адрес</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Подтверждение пароля</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>

</div>

@endsection