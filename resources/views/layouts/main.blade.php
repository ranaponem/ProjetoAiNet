<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineMagic - O centro do cinema!</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts AND CSS Fields -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @yield('header-title')
        </h2>
    </x-slot>
        <main>

            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @if (session('alert-msg'))
                    <x-alert type="{{ session('alert-type') ?? 'info' }}">
                        {!! session('alert-msg') !!}
                    </x-alert>
                @endif
                @if (!$errors->isEmpty())
                        <x-alert type="warning" message="Operation failed because there are validation errors!"/>
                @endif
                @yield('main')
            </div>
        </main>
    </div>
</x-app-layout>
</body>
</html>