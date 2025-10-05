<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/pagesCss/style.css') }}">
    <link rel="icon" href="{{ asset('img/ЛОГОТИП ФОТО 1.png') }}">
    <title>FamilyCreativy</title>
    @yield('styles')
</head>
<body>
<header>
    <div class="burger">
        <img class="navBurger" src="{{ asset('img/burgermenu.svg') }}" alt="burgermenu">
        <a href="{{ route('welcome') }}">FamilyCreativy</a>
    </div>
    <nav>
        <div>
            <a href="{{ route('services') }}">ПРАЙС</a>
            <a href="{{ route('portfolio') }}">ПОРТФОЛИО</a>
            <a href="{{ route('equipment') }}">ОБОРУДОВАНИЕ</a>
        </div>
        <a href="{{ route('welcome') }}">FamilyCreativy</a>
        <div>
            <a href="{{ route('studios') }}">СТУДИИ</a>
            <a href="{{ route('reviews') }}">ОТЗЫВЫ</a>
            <a href="{{ route('contacts') }}">КОНТАКТЫ</a>
            <div class="profile-dropdown">
                <img class="arrowBurger" src="{{ asset('img/chevron-down.png') }}" alt="Меню">
                <div class="dropdown-menu" style="display: none;">
                    @auth
                        <a href="{{ route('profile') }}">ПРОФИЛЬ</a>
                        <div class="language-option">
                            <span>ЯЗЫК:</span>
                            <strong>RU</strong>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" style="margin-top: 12px;">
                            @csrf
                            <button class="exit" type="submit" style="background: none; border: none; color: #333; font-family: 'Jost-regulat'; font-size: 1rem; cursor: pointer; width: 100%; text-align: left;">
                                ВЫХОД
                            </button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}">ВХОД</a>
                        <a href="{{ route('registration') }}">РЕГИСТРАЦИЯ</a>
                        <div class="language-option">
                            <span>ЯЗЫК:</span>
                            <strong>RU</strong>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>
<main>
    @yield('content')
</main>
<footer>
    <div>
        <div>
            <div class="footer-name">
                <a href="{{ route('welcome') }}">FamilyCreativy</a>
            </div>
            <div class="footer-link">
                <div>
                    <a href="{{ route('studios') }}">СТУДИИ</a>
                    <a href="{{ route('services') }}">ПРАЙС</a>
                    <a href="{{ route('equipment') }}">ОБОРУДОВАНИЕ</a>
                </div>
                <div>
                    <a href="{{ route('portfolio') }}">ПОРТФОЛИО</a>
                    <a href="{{ route('reviews') }}">ОТЗЫВЫ</a>
                    <a href="{{ route('contacts') }}">КОНТАКТЫ</a>
                </div>
            </div>
        </div>
        <img draggable="false" src="{{ asset('img/ЛОГОТИП ФОТО 1.png') }}" alt="logo">
    </div>
</footer>
@yield('styles')
<script defer src="{{ asset('js/script.js') }}"></script>
<script defer src="{{ asset('js/imgModal.js') }}"></script>
</body>
</html>
