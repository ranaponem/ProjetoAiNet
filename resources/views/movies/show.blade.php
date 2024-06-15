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
                    <p class="font-bold mt-8 text-xl text-black dark:text-gray-50">Genre: {{ $movie->genre ? $movie->genre->name : 'No genre available' }}</p>
                    <p class="font-bold text-xl text-black dark:text-gray-50">Year: {{ $movie->year }}</p>

                </div> 
                
                
            </div>
            <div class="mt-10 flex">
                <h1 class="w-3/6 inline-block font-bold text-3xl text-black dark:text-gray-50 mb-5 ml-5">Trailer:</h1>
                <h1 class="w-1/3 inline-block font-bold text-3xl text-black dark:text-gray-50 mb-5">Select a screening:</h1>
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
