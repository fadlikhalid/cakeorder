<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Laravel App')</title>
    @vite(['resources/css/app.css']) <!-- Use @vite to load your CSS -->
</head>
<body>
    <div class="container">
        @include('partials.navbar') <!-- Include your navigation bar -->
        @yield('content') <!-- This is where content from child views will be injected -->
    </div>
    @vite(['resources/js/app.js']) <!-- Use @vite to load your JavaScript -->
</body>
</html>
