<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'QC') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Main CSS -->
    <link type="text/css" href="{{ asset('assets/css/auth-style.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/components.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/stripe.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/layout.css') }}" rel="stylesheet">

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

    <script>
        let baseUrl = "{{ url('/') }}";
        let zoomEffect = "{{ env('IMAGE_ZOOM_EFFECT', 'false') }}";
    </script>
    @if (auth()->check() && auth()->user()->type == \App\Enums\UserType::COACH)
        <style>
            .setup-team-alert {
                max-width: unset;
            }
            .dropdown-content {
                margin-top: 143px;
            }
        </style>
    @endif
</head>

<body>
    @php
        $homeUrl = auth()->check() ? getCurrentUserHomeUrl() : url('/');
    @endphp
    <form id="redirectToUrl" method="POST">
        @csrf
    </form>
    <div class="font-sans antialiased text-gray-900 auth-main">
        @include('layouts.header')
        <div {!! $attributes->merge(['class' => 'auth-main-body auth-container']) !!}>
            <div id="progress-bar" style="display:none">
                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
            </div>
            {{ $slot }}
        </div>
        @include('layouts.footer')
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    function redirectTo(url, method = 'post') {
        if (method.toLowerCase() == 'get') {
            window.location.href = url;
        } else {
            $('#redirectToUrl').attr('action', url);
            $('#redirectToUrl').attr('method', method);
            $('#redirectToUrl').submit();
        }
    }

    function updateCsrfToken() {
        document.querySelector('meta[name="csrf-token"]').setAttribute('content', "{{ csrf_token() }}");
    }
    let base_url = "{{ url('/') }}";
</script>
@stack('script')
<script>
    try {
        if (typeof paypal !== 'undefined' && hideValidationError == 'true') {
            setTimeout(() => {
                $('.input-error').remove();
            }, 5000);
        }
    } catch (error) {
        console.log('failed to hide errors', error);
    }
    $(function() {
        $('.password-toggle').click(function(event) {
            const type = $(this).parent().find('input').attr("type") === "password" ? "text" :
                "password";
            $(this).parent().find('input').attr("type", type);
            $(this).toggleClass("fa-eye fa-eye-slash");
        });
        try {
            var longText = $('#long-text');
            var longTextContent = $('#long-text .content-text');
            var readMore = $('.read-more');
            var readLess = $('.read-less');

            readMore.click(function(event) {
                event.preventDefault();
                longTextContent.html(longText.attr('data-long-text'));
                readMore.hide();
                readLess.show();
            });

            readLess.click(function(event) {
                event.preventDefault();
                longTextContent.html(longText.attr('data-truncated-text'));
                readMore.show();
                readLess.hide();
            });
        } catch (error) {
            console.log('readMore-error', error)
        }
    });
</script>

</html>
