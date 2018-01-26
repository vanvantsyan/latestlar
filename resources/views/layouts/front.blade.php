<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('css/panton.css')}}">
    <link rel="stylesheet" href="{{asset('css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.formstyler.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.formstyler.theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/datePicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    @yield('css')
    <link href='{{asset('/css/style.css')}}' rel='stylesheet' type='text/css'/>

    <meta name="description" content="@yield('description')"/>
    <meta name="keywords" content="@yield('keywords')"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>

<body>

@include('front.modules.header')

@yield('breadcrumbs')

@yield('content')

@include('front.modules.footer')

@include('front.modules.scripts')

@yield('js')

</body>

</html>
