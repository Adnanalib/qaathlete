<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:500,400italic,100,700italic,300,700,500italic,400"
        rel="stylesheet">
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--Jasmine Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <!--Font Awesome [ OPTIONAL ]-->
    <link href="{{ asset('admin/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!--Switchery [ OPTIONAL ]-->
    <link href="{{ asset('admin/plugins/switchery/switchery.min.css') }}" rel="stylesheet">
    <!--Bootstrap Select [ OPTIONAL ]-->
    <link href="{{ asset('admin/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">
    <!--ricksaw.js [ OPTIONAL ]-->
    <link href="{{ asset('admin/plugins/jquery-ricksaw-chart/css/rickshaw.css') }}" rel="stylesheet">
    <!--Bootstrap Validator [ OPTIONAL ]-->
    <link href="{{ asset('admin/plugins/bootstrap-validator/bootstrapValidator.min.css') }}" rel="stylesheet">
    <!--Demo [ DEMONSTRATION ]-->
    <link href="{{ asset('admin/css/demo/jquery-steps.min.css') }}" rel="stylesheet">
    <!--Summernote [ OPTIONAL ]-->
    <link href="{{ asset('admin/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    <!--Demo [ DEMONSTRATION ]-->
    <link href="{{ asset('admin/css/demo/jasmine.css') }}" rel="stylesheet">
    <!--SCRIPT-->
    <!--=================================================-->
    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="{{ asset('admin/plugins/pace/pace.min.css') }}" rel="stylesheet">
    <script src="{{ asset('admin/plugins/pace/pace.min.js') }}"></script>
    <link href="{{ asset('admin/plugins/remixicon/remixicon.css') }}" rel="stylesheet">


    @yield('style')

</head>

<body>
    <div id="container" class="effect mainnav-sm navbar-fixed mainnav-fixed">
        @include('admin.layouts.header')

        <div class="boxed">
            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                @include('admin.layouts.breadcum', [
                    'name' => 'Dashboard',
                ])
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('admin.layouts.navbar')
        @include('admin.layouts.footer')
    </div>
    <script src="{{ asset('admin/js/jquery-2.1.1.min.js') }}"></script>
    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>

    <!--Jquery Nano Scroller js [ REQUIRED ]-->
    <script src="{{ asset('admin/plugins/nanoscrollerjs/jquery.nanoscroller.min.js') }}"></script>
    <!--Metismenu js [ REQUIRED ]-->
    <script src="{{ asset('admin/plugins/metismenu/metismenu.min.js') }}"></script>
    <!--Jasmine Admin [ RECOMMENDED ]-->
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <!--Summernote [ OPTIONAL ]-->
    <script src="{{ asset('admin/plugins/summernote/summernote.min.js') }}"></script>
    <!--Fullscreen jQuery [ OPTIONAL ]-->
    <script src="{{ asset('admin/plugins/screenfull/screenfull.js') }}"></script>
    <script src="{{ asset('admin/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('admin/js/toaster.js') }}"></script>
    @if (Session::has('success'))
        <script>
            show_toastr('{{ __('Success') }}', '{!! session('success') !!}', 'success');
        </script>
        {{ Session::forget('success') }}
    @endif
    @if (Session::has('error'))
        <script>
            show_toastr('{{ __('Error') }}', '{!! session('error') !!}', 'error');
        </script>
        {{ Session::forget('error') }}
    @endif
    @yield('scripts')

</body>

</html>
