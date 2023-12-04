<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ $websiteTitle }} | @yield('title')
    </title>
    @vite(['resources/sass/app.scss'])
</head>
<body>
    <div id="bodyBackground" class="position-fixed vh-100 vw-100 top-0 left-0 opacity-25 bg-light"></div>
    <div class="body-container mx-auto vh-100 vw-100 bg-light position-relative">
        @include('layout.header')
        <div class="container-fluid pt-5">
            <h1 class="text-primary text-center mb-3">
                {{ $title }}
            </h1>
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js'])
</html>
