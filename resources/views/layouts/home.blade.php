<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-dark navbar-expand-lg bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Projeto Empresarial</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-navbar"
                aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-navbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('index') }}">
                        Página inicial
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('shop') ? 'active' : '' }}" href="{{ route('shop.index') }}">
                        Produtos
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @if(session()->get('cart') != null)
                    <li class="nav-auto me-4">
                        <a class="nav-link {{ Request::is('shop/cart*') ? 'active' : '' }} position-relative"
                           href="{{ route('shop.cart.index') }}">
                            <span>Carrinho</span>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ count(session()->get('cart')) }}
                            </span>
                        </a>
                    </li>
                @endif

                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item {{ Request::is('me*') ? 'active' : '' }}"
                               href="{{ route('me.index') }}">
                                Meus dados
                            </a>

                            @if(auth()->user()->is_admin == 1)
                                <a class="dropdown-item" href="{{ route('admin.index') }}">
                                    Dashboard
                                </a>
                            @endif

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<main class="w-100 bg-light">
    <div class="d-flex flex-nowrap min-vh-100">
        @yield('header')
        <div class="my-5 flex-grow-1">
            <div class="container-sm bg-body">
                @yield('content')
            </div>
        </div>
    </div>
</main>
</body>

</html>
