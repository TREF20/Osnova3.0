<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ОСНОВА — Женская одежда</title>

    <!-- Подключаем Bootstrap 5.3 CSS (с CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">

    <!-- Твой кастомный CSS (он идёт ПОСЛЕ Bootstrap, чтобы переопределять стили) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    
    <!-- Твой JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>

    <header>
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="logo">ОСНОВА</a>

            <nav class="nav-links">
                @if (auth()->check())
                    <span class="user-greeting">Привет, {{ auth()->user()->name }}</span>

                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.products.index') }}" title="Админ-панель">🛠</a>
                    @endif

                    <a href="{{ route('cart') }}" class="cart-link" title="Корзина">
                        🛒 <span class="cart-count">{{ count(Session::get('cart', [])) }}</span>
                    </a>
                    <a href="{{ route('info') }}">О нас</a>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}">Вход</a>
                    <a href="{{ route('register') }}">Регистрация</a>
                @endif
            </nav>
        </div>
    </header>

    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif

    @yield('content')

    <footer>
        <div class="container">
            <p>© {{ date('Y') }} ОСНОВА МАГАЗИН. Все права защищены.</p>
        </div>
    </footer>

    <!-- Подключаем Bootstrap 5.3 JS (с поппером и всем нужным) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
            crossorigin="anonymous"></script>
</body>
</html>