<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="icon" href="https://werkenbijkik.nl/wp-content/uploads/2023/03/cropped-KiK_Logo_3D_4c-32x32.png" sizes="32x32" />
        <link rel="icon" href="https://werkenbijkik.nl/wp-content/uploads/2023/03/cropped-KiK_Logo_3D_4c-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon" href="https://werkenbijkik.nl/wp-content/uploads/2023/03/cropped-KiK_Logo_3D_4c-180x180.png" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased h-full">
        @inertia
    </body>
</html>
