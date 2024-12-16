<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

    <!-- Scripts -->

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}"> --}}
    @routes

    @inertiaHead
</head>

<body class="font-sans antialiased">
    {{-- <div id="loading-bg">
        <div class="loading-logo">
        </div>
        <div class=" loading">
            <div class="effect-1 effects"></div>
            <div class="effect-2 effects"></div>
            <div class="effect-3 effects"></div>
        </div>
    </div> --}}
    @inertia
    @vite(['resources/ts/main.ts', "resources/ts/Pages/{$page['component']}.vue"])
</body>

</html>
