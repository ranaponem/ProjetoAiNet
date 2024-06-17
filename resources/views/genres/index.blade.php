@extends('layouts.main')

@section('header-title', 'All Genres')

@section('main')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">All Genres</h1>
                    <a href="{{ route('genres.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Create Genre</a>
                </div>

                @if($genres->isEmpty())
                    <p>No genres found.</p>
                @else
                    <table class="min-w-full bg-white">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Code</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($genres as $genre)
                            <tr>
                                <td class="border px-4 py-2">{{ $genre->code }}</td>
                                <td class="border px-4 py-2">{{ $genre->name }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('genres.edit', $genre->code) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('genres.destroy', $genre->code) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
