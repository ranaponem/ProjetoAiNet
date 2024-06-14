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
<div class="min-h-screen bg-gray-100 dark:bg-gray-800">

        <!-- Navigation Menu -->
        <nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
            <!-- Navigation Menu Full Container -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Logo + Menu Items + Hamburger -->
                <div class="relative flex flex-col sm:flex-row px-6 sm:px-0 grow justify-between">
                    <!-- Logo -->
                    <div class="shrink-0 -ms-4">
                        <a href="{{ route('home')}}">
                            <div class="h-16 w-16 bg-cover bg-[url('../img/templogo.svg')] dark:bg-[url('../img/templogo.svg')]"></div>
                        </a>
                    </div>

                    <!-- Menu Items -->
                    <div id="menu-container" class="grow flex flex-col sm:flex-row items-stretch
                    invisible h-0 sm:visible sm:h-auto">

                        <div class="grow"></div>

                        <!-- Menu Item: Cart -->
                        @if (session('cart'))
                            @can('use-cart')
                            <x-menus.cart
                                :href="route('cart.show')"
                                selectable="1"
                                selected="{{ Route::currentRouteName() == 'cart.show'}}"
                                :total="session('cart')->count()"/>
                            @endcan
                        @endif

                        @auth
                        <x-menus.submenu
                            selectable="0"
                            uniqueName="submenu_user"
                            >
                            <x-slot:content>
                                <div class="pe-1">
                                    <img src="{{Auth::user()->getImageUrlAttribute()}}" class="w-11 h-11 min-w-11 min-h-11 rounded-full">
                                </div>
                                <div class="ps-1 sm:max-w-[calc(100vw-39rem)] md:max-w-[calc(100vw-41rem)] lg:max-w-[calc(100vw-46rem)] xl:max-w-[34rem] truncate">
                                    {{ Auth::user()->name }}
                                </div>
                            </x-slot>
                            @auth
                            <hr>
                            <x-menus.submenu-item
                                content="Profile"
                                selectable="0"
                                href="{{ route('profile.edit')}} "/>
                            @endauth
                            <hr>
                            <form id="form_to_logout_from_menu" method="POST" action="{{ route('logout') }}" class="hidden">
                                @csrf
                            </form>
                            <x-menus.submenu-item
                                content="Log Out"
                                selectable="0"
                                form="form_to_logout_from_menu"/>
                        </x-menus.submenu>
                        @else
                        <!-- Menu Item: Login -->
                        <x-menus.menu-item
                            content="Login"
                            selectable="1"
                            href="{{ route('login') }}"
                            selected="{{ Route::currentRouteName() == 'login'}}"
                            />
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    @yield('header-title')
                </h2>
            </div>
        </header>

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
</body>
</html>