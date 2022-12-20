<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Яндекс карты</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/">Главная</a>
        </li>
        @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('page.register') }}">Региcтрация</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('page.login') }}">Авторизация</a>
        </li>
        @endguest
        @auth


        <form action="{{ route('auth.logout') }}" method="post">
          @csrf
          <button type="submit" class="btn btn-primary">Выйти</button>
        </form>
        <!-- <li class="nav-item">
          <a class="nav-link" href="{{ route('auth.logout') }}">Выйти</a>
        </li> -->
        @endauth

    </div>
  </div>
</nav>