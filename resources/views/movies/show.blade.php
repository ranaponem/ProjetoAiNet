@extends('layouts.main')

@section('header-title', $movie->title)

@section('main')

<main>
    <div class="h-full flex flex-wrap justify-center">
        <div class="w-full h-full rounded shadow-lg bg-white dark:bg-gray-900 p-2 ">
            <div class="h-1/6 p-4 flex">
                <img class="h-1/6 w-auto inline-block mr-4 rounded" src="{{ $movie->getImageUrlAttribute() }}" alt="{{ $movie->poster_filename }}">
                <div class="inline-block flex flex-col justify-start">
                    
                    <h1 class="font-bold text-3xl text-black dark:text-gray-50 mb-5">Synopsis:</h1>
                    <p class="font-bold text-black dark:text-gray-50">{{ $movie->synopsis }}</p>

                </div> 
                
            </div>
        </div>

    </div>
    
</main>

@endsection
