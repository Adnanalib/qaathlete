<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Main CSS -->
    <link type="text/css" href="{{ asset('assets/css/auth-style.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/components.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/stripe.css') }}" rel="stylesheet">

    <!-- Font CSS -->

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Barlow|InaiMathi|Nunito:wght@400;600;700&display=swap|Fugaz+One:regular|Work+Sans:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic&#038;subset=latin,latin-ext&#038;display=swap">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @include('layouts.favicon')
    @stack('head')
</head>

<body>
    <div class="font-sans antialiased text-gray-900 auth-main">
        <header class="flex">
            <div class="flex header-img-container">
                <img src="{{ asset('assets/images/header-logo-auth.png') }}"
                    onclick="window.location.href='{{ route('login') }}'" class="cursor-pointer" alt="QC" />
            </div>
            <div class="flex header-content-container">
                <ul class="desktop-menu">
                    <li class="auth-link"><a href="#" class="auth-link">QR Apparel</a></li>
                    <li class="auth-link search-before-icon"><a href="https://quickcaptureathletics.com/about-us"
                            class="auth-link">About us</a></li>
                    <li class="auth-link-icon profile search-icon">
                        <span class="dropdown">
                            <img src="{{ asset('assets/images/icons/search.png') }}"
                                    alt="Search Athlete and Coach" />
                            <div class="dropdown-content">
                                <form action="{{route('search-athlete-coach')}}" method="post">
                                    <div class="row">
                                        <div class="mt-0 form-group form-focus col-md-12">
                                            @csrf
                                            <x-text-input class="block w-full" type="text" :placeholder="__('Search')" name="search"  />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </span>
                    </li>
                    <li class="auth-link button">
                        @if (\Request::is('register') || \Request::is('coach/register'))
                            <button onclick="window.location.href='{{ route('login') }}'" class="header-btn">
                                {{ __('Login') }}
                            </button>
                        @else
                            <button onclick="window.location.href='{{ route('register') }}'" class="header-btn">
                                {{ __('Signup') }}
                            </button>
                        @endif
                    </li>
                </ul>
                <input type="checkbox" id="active" class="menu-options">
                <label for="active" class="menu-btn menu-options"><span></span></label>
                <label for="active" class="close menu-options"></label>
                <div class="wrapper mobile-menu">
                    <ul>
                        <li><a href="#">QR Apparels</a></li>
                        <li><a href="https://quickcaptureathletics.com/about-us">About us</a></li>
                        <li>
                            <form action="{{route('search-athlete-coach')}}" method="post">
                                @csrf
                                <x-text-input class="block w-full mobile-search-result" type="text" :placeholder="__('Search Athlete')" name="search"  />
                            </form>
                        </li>
                        <li class="auth-link button">
                            @if (\Request::is('register') || \Request::is('coach/register'))
                                <button onclick="window.location.href='{{ route('login') }}'" class="header-btn">
                                    {{ __('Login') }}
                                </button>
                            @else
                                <button onclick="window.location.href='{{ route('register') }}'" class="header-btn">
                                    {{ __('Signup') }}
                                </button>
                            @endif
                    </ul>
                </div>
            </div>
        </header>
        <div class="auth-main-body auth-container">
            {{ $slot }}
        </div>
        {{-- @include('layouts.footer') --}}
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    function chooseOption(id) {
        document.getElementById(id).click();
    }
    $("#register-form").submit(function(event) {
        $("#register-form button").html('Registering....');
        $("#register-form button").prop('disabled', true);
    });
    $("#login-form").submit(function(event) {
        $("#login-form button").html('Login....');
        $("#login-form button").prop('readOnly', true);
    });
    $(function() {
        $('.password-toggle').click(function(event) {
            const type = $(this).parent().find('input').attr("type") === "password" ? "text" :
                "password";
            $(this).parent().find('input').attr("type", type);
            $(this).toggleClass("fa-eye fa-eye-slash");
        });
    });
    $(document).ready(function() {
        $('.auth-link-icon.search-icon').hover(
            function() {
                $(this).find('img').attr('src', "{{ asset('assets/images/icons/search-hover.png') }}");
            },
            function() {
                $(this).find('img').attr('src', "{{ asset('assets/images/icons/search.png') }}");
            }
        );
    });
</script>

@stack('script')

</html>
