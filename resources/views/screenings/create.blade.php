@extends('layouts.main')

@section('header-title', 'Create Screening')

@section('main')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Create New Screening</h2>
                <form action="{{ route('screenings.store') }}" method="POST">
                    @csrf

                    <!-- Movie ID (hidden) -->
                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                    <!-- Theater -->
                    <div class="mt-6">
                        <label for="theater_id" class="block font-medium text-gray-700">Theater</label>
                        <select name="theater_id" id="theater_id"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select Theater</option>
                            @foreach ($theaters as $theater)
                                <option value="{{ $theater->id }}">{{ $theater->name }}</option>
                            @endforeach
                        </select>
                        @error('theater_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="mt-6">
                        <label for="date" class="block font-medium text-gray-700">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div class="mt-6">
                        <label for="start_time" class="block font-medium text-gray-700">Start Time</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('start_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-white bg-blue-500 hover:bg-blue-600 transition duration-200">
                            Create Screening
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
