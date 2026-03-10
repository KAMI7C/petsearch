<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PetSearch') — найти друга</title>
    
   
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap" rel="stylesheet">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container header__inner">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-paw logo__icon"></i>
                <span class="logo__text">PetSearch</span>
            </a>
            
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item"><a href="{{ route('posts.index') }}" class="nav__link">Объявления</a></li>
                    <li class="nav__item"><a href="{{ route('about') }}" class="nav__link">О проекте</a></li>
                    
                    @auth
                        <li class="nav__item"><a href="{{ route('posts.create') }}" class="nav__link nav__link--accent">➕ Добавить</a></li>
                        <li class="nav__item nav__item--dropdown">
                            <span class="nav__link nav__link--user">
                                <i class="far fa-user-circle"></i> {{ Auth::user()->name }}
                            </span>
                            <ul class="dropdown">
                                <li><a href="{{ route('profile.show') }}" class="dropdown__link">Личный кабинет</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown__link dropdown__link--logout">Выйти</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav__item"><a href="{{ route('login') }}" class="nav__link">Вход</a></li>
                        <li class="nav__item"><a href="{{ route('register') }}" class="nav__link nav__link--accent">Регистрация</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    @if(session('success'))
        <div class="alert alert--success container">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer__inner">
            <div class="footer__col">
                <h4 class="footer__title">PetSearch</h4>
                <p class="footer__text">Помогаем воссоединять семьи с питомцами с 2026 года</p>
            </div>
            <div class="footer__col">
                <h4 class="footer__title">Навигация</h4>
                <ul class="footer__list">
                    <li><a href="{{ route('posts.index') }}">Все объявления</a></li>
                    <li><a href="{{ route('about') }}">О проекте</a></li>
                    <li><a href="#">Правила</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h4 class="footer__title">Контакты</h4>
                <p><i class="far fa-envelope"></i> help@petsearch.ru</p>
                <p><i class="fas fa-phone"></i> 8 (800) 123-45-67</p>
            </div>
        </div>
        <div class="footer__bottom">
            <p>© {{ date('Y') }} PetSearch. Сделано с заботой.</p>
        </div>
    </footer>
</body>
</html>