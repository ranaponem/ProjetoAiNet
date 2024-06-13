@extends('layouts.main')

@section('header-title', 'Movies on show')

@section('main')
<main>
    
    <div class=" w-full md:w-1/2 lg:w-1/5 p-2 ">
        <div class="rounded overflow-hidden shadow-lg bg-white dark:bg-gray-900 ">
            <img class="w-full" src="https://via.placeholder.com/200x300" alt="Poster">
            <h1 class="text-center font-bold text-xl mb-4 mt-4 text-black dark:text-gray-50">\Movie name\</h1>
        </div>
    </main>
@endsection
