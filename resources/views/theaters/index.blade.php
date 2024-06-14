@extends('layouts.main')

@section('header-title', 'Theaters')

@section('main')

<main>
    <div class="flex flex-wrap justify-center">
    @foreach($theaters as $theater)
    
        <div class="w-full p-2">
            <div class="h-full rounded overflow-hidden shadow-lg bg-white dark:bg-gray-900">
                <h1 class="text-left font-bold ml-4 mb-4 mt-4 text-black dark:text-gray-50">{{$theater->name}}</h1>
                @can('update', $theater)
                <a href="{{route('theaters.edit', ['theater' => $theater])}}">
                    Edit
                </a>
                @endcan
                @can('delete', $theater)
                <a href="{{route('theaters.destroy', ['theater' => $theater])}}">
                    Delete
                </a>
                @endcan
            </div>
        </div>
    
    @endforeach
    @can('create', App\Models\Theater::class)
                <div class="flex items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('theaters.create') }}"
                        text="Insert a new theater"
                        type="success"/>
                </div>
    </div>
    @endcan
</main>

@endsection