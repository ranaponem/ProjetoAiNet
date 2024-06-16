@extends('layouts.main')

@section('header-title', 'Create Movie')

@section('main')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <form action="{{route('movies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Movie Title -->
                    <div class="mt-6">
                        <label for="title" class="block font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $movie->title ?? '') }}" required autofocus
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Movie Trailer URL -->
                    <div class="mt-6">
                        <label for="trailer_url" class="block font-medium text-gray-700">Trailer URL</label>
                        <input type="text" name="trailer_url" id="trailer_url" value="{{ old('trailer_url', $movie->trailer_url ?? '') }}" required autofocus
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('trailer_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Movie Genre -->
                    <div class="mt-6">
                        <label for="genre_code" class="block font-medium text-gray-700">Genre</label>
                        <select name="genre_code" id="genre_code"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select Genre</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->code }}" {{ old('genre_code', $movie->genre_code ?? '') == $genre->code ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('genre_code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Movie Poster -->
                    <div class="grow mt-9 space-y-4 inline-block pb-4">
                        <x-field.image
                            id="image_file"
                            name="image_file"
                            label="Theater Picture"
                            width="md"
                            height=""
                            deleteTitle="Delete"
                            :deleteAllow="$movie->getImageExistsAttribute()"
                            deleteForm="form_to_delete_image"
                            :imageUrl="$movie->getImageUrlAttribute()"
                        />
                    </div>

                    <!-- Movie Year -->
                    <div class="mt-6">
                        <label for="year" class="block font-medium text-gray-700">Year</label>
                        <input type="number" name="year" id="year" value="{{ old('year', $movie->year ?? '') }}" required autofocus
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Movie Synopsis -->
                    <div class="mt-6">
                        <label for="synopsis" class="block font-medium text-gray-700">Synopsis</label>
                        <textarea name="synopsis" id="synopsis" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('synopsis', $movie->synopsis ?? '') }}</textarea>
                        @error('synopsis')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-white bg-blue-500 hover:bg-blue-600 transition duration-200">
                            {{'Create Movie'}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
