<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'L\'Usine Chocolat') }}</title>

        {{-- Styles --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Thème chocolat custom --}}
        <style>
            :root {
                --choco-brown: #3C2B28;
                --choco-beige: #F5E8C7;
                --choco-gold: #D4B384;
                --choco-dark: #8B4513;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-[#FDF3D8] to-[#F5E8C7] min-h-screen">
        <div class="min-h-screen bg-gray-100">
            {{-- Navigation --}}
            @include('layouts.navigation')

            {{-- Page content --}}
            <main>
                {{ $header ?? '' }}
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
