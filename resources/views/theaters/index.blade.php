@extends('layouts.main')

@section('header-title', 'Theaters')

@section('main')

    <main>
        <div class="grid grid-cols-1 gap-4 my-6">
            @can('create', App\Models\Theater::class)
                <div class="flex items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('theaters.create' ) }}"
                        text="Insert a new theater"
                        type="success"/>
                </div>
        </div>
        @endcan
        @foreach($theaters as $theater)

            <div class="bg-white dark:bg-gray-800 overflow-hidden -my-2 sm:rounded-lg flex">
                <div class="p-6 sm:px-3 bg-white dark:bg-gray-800  w-full flex">
                    <div class=" sm:px-10 bg-white dark:bg-gray-800 border-gray-600 w-64 inline-block">
                        <div class="flex justify-center">
                            @if($theater->photo_filename)
                                <img src="{{ $theater->getImageUrlAttribute() }}" alt="Profile Picture"
                                     class="rounded-full h-32 w-32 object-cover">
                            @else
                                <div class="rounded-full h-32 w-32 bg-gray-700 flex items-center justify-center text-gray-300">
                                    <span>{{ __('No Image') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class=" sm:px-10 bg-white dark:bg-gray-800 border-gray-600 w-full inline-block">
                        <div class="w-full" >
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                          :value="$theater->name" required autofocus autocomplete="name" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="h-full justify-end rounded overflow-hidden bg-gray-80 flex">
                            @can('update', $theater)
                                <div class="mt-6 mx-6">
                                    <a href="{{route('theaters.edit', ['theater' => $theater])}}"
                                       class="inline-block px-4 py-2 rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition duration-200">
                                        {{ __('Edit') }}
                                    </a>
                                </div>
                            @endcan
                            @can('delete', $theater)
                                <div class="mt-6">
                                    <x-danger-button class="py-3"
                                                     x-data=""
                                                     x-on:click.prevent="$dispatch('open-modal', 'confirm-theater-deletion')"
                                    >{{ __('Delete Theater') }}</x-danger-button>


                                </div>
                            @endcan
                        </div>
                    </div>


                </div>

            </div>

        @endforeach
        <x-modal name="confirm-theater-deletion" :show="$errors->theaterDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('theaters.destroy', $theater) }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete this theater?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once this theater is deleted, all of its resources and data will be permanently deleted.') }}
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Theater') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </main>

@endsection