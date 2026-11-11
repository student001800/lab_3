<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Города Португалии')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('cities.index') }}">
            <span class="logo-box me-2">PT</span><span>Города Португалии</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Открыть меню">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('cities.index') }}">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('cities.index') }}#cities">Города</a></li>
                <li class="nav-item ms-lg-2"><a class="btn btn-primary" href="{{ route('cities.create') }}">Добавить город</a></li>
                <li class="nav-item ms-lg-2"><button class="btn btn-outline-light" id="loadBtn" type="button">Загрузить</button></li>
            </ul>
        </div>
    </div>
</nav>
<main class="container my-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    @endif
    @yield('content')
</main>
<footer class="bg-dark text-light py-4 mt-5">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>Выполнил: Студент · Лабораторная работа №3</div>
        <div class="d-flex gap-3">
            <a href="#" class="text-light" aria-label="LinkedIn"><i class="fa-brands fa-linkedin fa-lg"></i></a>
            <a href="#" class="text-light" aria-label="Facebook"><i class="fa-brands fa-facebook fa-lg"></i></a>
            <a href="#" class="text-light" aria-label="Twitter"><i class="fa-brands fa-twitter fa-lg"></i></a>
        </div>
    </div>
</footer>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="loadToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fa-solid fa-spinner fa-spin me-2 text-primary"></i>
            <strong class="me-auto">Загрузка</strong>
            <small>только что</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
        </div>
        <div class="toast-body">На текущий момент этот функционал недоступен.</div>
    </div>
</div>
@stack('scripts')
</body>
</html>
