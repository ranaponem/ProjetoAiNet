@extends('layouts.main')

@section('header-title', 'Create Genre')

@section('main')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold mb-6">Create Genre</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('genres.store') }}" method="POST" id="createGenreForm">
                    @csrf

                    <div class="mb-4">
                        <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                        <input readonly type="text" name="code" id="code" value="{{ old('code') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Create Genre</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // JavaScript code to generate capitalized and cleaned code based on the name input in real-time
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const codeInput = document.getElementById('code');

            nameInput.addEventListener('input', function () {
                const cleanedName = nameInput.value.trim().toUpperCase().replace(/\s+/g, '-');
                const capitalizedCode = cleanedName.replace(/(^|\-)([a-z])/g, function(match, group1, group2) {
                    return group2.toUpperCase();
                });

                codeInput.value = capitalizedCode;
            });
        });
    </script>
@endsection
