<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Meus agendamentos | @yield('title')</title>
    <link rel="icon" sizes="180x180" href="{{ asset('front/image/favicon.png') }}">
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('front/css/schedules.css') }}" rel="stylesheet" crossorigin="anonymous">
    <link href="{{ asset('front/css/my_schedules.css') }}" rel="stylesheet" crossorigin="anonymous">
    <link href="{{ asset('front/css/layout.main.css') }}" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')
    <style>
        .navbar-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }
        .navbar-custom .nav-links {
            display: flex;
            gap: 1rem;
        }
        .navbar-custom .nav-links a {
            text-decoration: none;
            color: black;
        }
        .navbar-custom .nav-links a.disabled {
            color: grey;
            pointer-events: none;
        }
        .navbar-custom .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }
        .navbar-custom .menu-toggle div {
            width: 25px;
            height: 3px;
            background-color: black;
            margin: 4px 0;
            transition: all 0.3s ease;
        }
        .navbar-custom .menu-toggle.open div:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        .navbar-custom .menu-toggle.open div:nth-child(2) {
            opacity: 0;
        }
        .navbar-custom .menu-toggle.open div:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }
        @media (max-width: 768px) {
            .navbar-custom .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
            }
            .navbar-custom .nav-links.show {
                display: flex;
            }
            .navbar-custom .menu-toggle {
                display: flex;
            }
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<header>
    <nav class="navbar navbar-custom bg-white shadow">
        <a class="navbar-brand" href="{{ route('web-home.index') }}">
            <img src="{{ asset('front/image/dental+.png') }}" alt="Descrição da Imagem" width="250">
        </a>
        <div class="menu-toggle" id="menu-toggle">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="nav-links" id="nav-links">
            <form class="d-flex me-7 mt-2">
                <input class="form-control rounded-lg me-2" type="search" placeholder="O que você deseja?" aria-label="Search">
                <button class="btn rounded-lg btn-outline-primary" type="submit">Pesquisar</button>
            </form>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border-0 text-sm leading-4 font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 shadow-none">
                        @if (Auth::check())
                            @if (isset($hasImage) && $hasImage)
                                <img src="{{ $imageUrl }}" alt="Profile Image" width="50" class="pr-3">
                            @else
                                <img src="{{ $imageUrl }}" alt="Default Profile Image" width="50" class="pr-3">
                            @endif
                            <div>{{ Auth::user()->name }}</div>
                        @else
                            <img src="{{ asset('front/image/default-profile.png') }}" alt="Guest" width="50" class="pr-3">
                            <div></div>
                        @endif
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>
                <x-slot name="content">
                    @if (Auth::check())
                        @if (Auth::user()->isAdmin())
                            <x-dropdown-link :href="route('home.index')">
                                {{ __('Dashboard Admin') }}
                            </x-dropdown-link>
                        @endif
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Editar Perfil') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('meus-agendamentos')">
                            {{ __('Meus agendamentos') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                      this.closest('form').submit();">
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </form>
                    @else
                        <x-dropdown-link :href="route('login')">
                            {{ __('Login') }}
                        </x-dropdown-link>
                    @endif
                </x-slot>
            </x-dropdown>
        </div>
    </nav>
</header>

<main class="flex-shrink-0">
    @yield('content')
</main>

<footer class="bg-white text-center mt-auto py-3">
    <div class="container">
        <span>&copy; Estética Dental 2024</span>
    </div>
</footer>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#menu-toggle').click(function() {
            $('#nav-links').toggleClass('show');
            $(this).toggleClass('open');
        });
    });
</script>
<script src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
@yield('js')

</body>
</html>
