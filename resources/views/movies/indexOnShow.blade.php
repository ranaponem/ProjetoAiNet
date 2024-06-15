@extends('layouts.main')

@section('header-title', 'Movies on show')

@section('main')



<main>
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