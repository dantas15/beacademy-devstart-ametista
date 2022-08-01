<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
<div class="w-100 bg-light">
    <div class="d-flex flex-nowrap min-vh-100">
        <!-- Sidebar-->
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="{{ route('index') }}"
               class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.index') }}"
                       class="nav-link {{ Request::is('admin') ? 'active' : 'text-white' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}"
                       class="nav-link {{ Request::is('admin/orders*') ? 'active' : 'text-white' }}">
                        Pedidos
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}"
                       class="nav-link {{ Request::is('admin/products*') ? 'active' : 'text-white' }}">
                        Produtos
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}"
                       class="nav-link {{ Request::is('admin/users*') ? 'active' : 'text-white' }}">
                        Users
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="javascript:void(0)"
                   class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                   id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    {{--                    <img src="https://github.com/" alt="" class="rounded-circle me-2" width="32" height="32">--}}
                    <strong> {{ Auth::user()->name }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>

        <!-- Main content-->
        <div class="my-5 flex-grow-1">

            <main class="container-sm bg-body">
                @yield('content')
            </main>
        </div>
    </div>
</div>

</body>
</html>
