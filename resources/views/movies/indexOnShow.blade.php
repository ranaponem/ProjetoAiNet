@extends('layouts.main')

@section('header-title', 'Movies on show')

@section('main')



<main>
    <div class="flex justify-between">
        <div class="mb-6 w-4/5">
            <form action="{{ route('movies.indexOnShow') }}" method="GET" class="flex space-x-4 w-full">
                <input type="text" name="search" placeholder="{{ __('Search movies...') }}"
                        value="{{ request('search') }}"
                        class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 w-full md:w-1/3">
                <button type="submit"
                        class="inline-block px-4 py-2 rounded-md text-gray-900 bg-white hover:bg-gray-300 transition duration-200">
                    {{ __('Search') }}
                </button>

            </form>
        </div>
        <div class="flex flex-wrap justify-center">
            <x-dropdown-scroll align="right">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-5 py-4 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div class="pe-1">

                                </div>

                                @if(request('genre_code')==null)
                                    <div>Select Genre</div>
                                @else
                                    <div>{{request('genre_code')}}</div>
                                @endif
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                            <x-slot name="content" >
                                <x-dropdown-link href="{{ route('movies.indexOnShow', ['genre_code' => null]) }}">

                                        {{ __('All genres') }}

                                </x-dropdown-link>
                                @foreach($genres as $genre)
                                    <x-dropdown-link href="{{ route('movies.indexOnShow', ['genre_code' => $genre->code]) }}">

                                            {{ __($genre->name) }}

                                    </x-dropdown-link>
                                @endforeach
                            </x-slot>
                    </x-dropdown-scroll>

        </div>
    </div>
    <div class="flex flex-wrap justify-center">
    @foreach($moviesOnShow as $movie)

        <div class="w-full md:w-1/2 lg:w-1/5 p-2">
            <a href="{{ route('movies.show', ['movie' => $movie]) }}">
                <div class="h-full rounded overflow-hidden shadow-lg bg-white dark:bg-gray-900">
                    <img class="h-5/6 w-full"src="{{$movie->getImageUrlAttribute()}}" alt = {{$movie->poster_filename}}>
                    <h1 class="text-center font-bold mb-4 mt-4 text-black dark:text-gray-50">{{$movie->title}}</h1>
                </div>
            </a>
        </div>

    @endforeach
    </div>
</main>
@endsection
