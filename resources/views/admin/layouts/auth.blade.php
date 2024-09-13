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
    <link href="{{ asset('admin/css/auth.css') }}" rel="stylesheet">
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
    @include('layouts.favicon')
    @yield('style')

</head>

<body>
    @yield('content')
    <script src="{{ asset('admin/js/jquery-2.1.1.min.js') }} "></script>
    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="{{ asset('admin/js/bootstrap.min.js') }} "></script>
    <!--Bootstrap Select [ OPTIONAL ]-->
    <script src="{{ asset('admin/plugins/bootstrap-select/bootstrap-select.min.js') }} "></script>

</body>

</html>
