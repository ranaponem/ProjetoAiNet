@extends('layouts.main')

@section('header-title', $movie->title)

@section('main')
    <style>
        .no-scrollbar {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none; /* Hide scrollbar for Chrome, Safari, and Opera */
        }

    </style>
<main>
    <div class="flex h-screen flex-wrap justify-center">
        <div class="w-full h-screen rounded shadow-lg bg-white dark:bg-gray-900 p-2 ">
            <div class="h-2/5 flex overflow-y-scroll no-scrollbar">
                <img class="h-full w-auto inline-block mr-4 rounded" src="{{ $movie->getImageUrlAttribute() }}" alt="{{ $movie->poster_filename }}">
                <div class="inline-block flex flex-col justify-start">

                    <h1 class="font-bold text-3xl text-black dark:text-gray-50 mb-8">Synopsis:</h1>
                    <p class="font-bold text-xl text-black dark:text-gray-50">{{ $movie->synopsis }}</p>
                    <p class="font-bold mt-8 text-xl text-black dark:text-gray-50">Genre: {{ $movie->genre_code ? $movie->genre_code : 'No genre available' }}</p>
                    <p class="font-bold text-xl text-black dark:text-gray-50">Year: {{ $movie->year }}</p>

                </div>


            </div>
            <div class="mt-10 flex">
                <h1 class="w-3/6 inline-block font-bold text-3xl text-black dark:text-gray-50 mb-5 ml-5">Trailer:</h1>
                <div class="flex justify-center">
                        <h1 class=" inline-block font-bold text-3xl text-black dark:text-gray-50 mb-5">Select a screening:</h1>

                        <div class="inline-block mx-3 -mt-1">
                            <x-dropdown align="right">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-5 py-4 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        @if(request('genre_code')==null)
                                            <div>Select Timeframe</div>
                                        @else
                                            <div>{{request('filter')}}</div>
                                        @endif
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                    <x-slot name="content" >
                                        <x-dropdown-link href="{{ route('movies.show', ['movie' => $movie, 'filter' => '1' ]) }}">
                                            {{ __('Next Two weeks') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('movies.show', ['movie' => $movie,'filter' => '0']) }}">
                                            {{ __('Today') }}
                                        </x-dropdown-link>
                                    </x-slot>
                            </x-dropdown>
                        </div>
                    </div>

            </div>
            <div class=" h-2/5 flex mb-5">
                <div class="w-1/2 mt-4 flex ml-5">
                    <iframe width="90%" height="auto" src="{{ $movie->trailer_url }}" frameborder="0" allowfullscreen></iframe>
                </div>

                <div class="overflow-y-scroll no-scrollbar mt-4  justify-center">
                            @foreach ($screenings as $screening)
                        <a href="#">
                            <div class="flex hover:bg-gray-800">
                               <h1 class="inline-block text-center font-bold p-4 text-black dark:text-gray-50">Theater: {{$screening->theater->name}} </h1>
                               <h1 class="inline-block text-center font-bold p-4 text-black dark:text-gray-50">Date: {{$screening->date}} {{$screening->start_time}}</h1>
                            </div>

                        </a>
                        @endforeach

                </div>
        </div>
    </div>



</main>

@endsection
