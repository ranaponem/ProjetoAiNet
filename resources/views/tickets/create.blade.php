@extends('layouts.main')

@section('header-title', 'Confirmation')

@section('main')
    <div class="container mx-auto mt-6">
        

        <div class="mb-4 rounded p-10 text-black dark:text-white bg-white dark:bg-gray-800">
            <h2 class="text-gray-800 dark:text-white text-3xl font-bold mb-4">You are about to add a ticket for '{{ $screening->movie->title }}' to cart</h2>
            <div class="inline-block  mb-4 rounded py-4 px-8 text-gray-800 dark:text-white bg-gray-200 dark:bg-gray-700" >
                <p class="my-1 text-2xl"><strong>Movie:</strong> {{ $screening->movie->title }}</p>
                <p class="my-1"><strong>Date:</strong> {{ $screening->date }}</p>
                <p class="my-1"><strong>Screening Time:</strong> {{ $screening->start_time }}</p>
                <p class="my-1"><strong>Theater:</strong> {{ $screening->theater->name }}</p>
                <p class="my-1"><strong>Seat:</strong> {{ $seat->seat_number }}{{ $seat->row }}</p>
                <p class="my-1 text-xl "><strong>Price:</strong> {{ number_format($price, 2) }}€</p>
            </div>
            
        </div>
        <div class="flex justify-between">
            <a href="{{ route('screenings.show', ['screening'=>$screening]) }}">
                <x-secondary-button href="{{ route('screenings.show', ['screening'=>$screening]) }}">Cancel</x-secondary-button>
            </a>
            
 
            <div class="">
                <x-primary-button class="py-3"
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-ticket-add')"
                >{{ __('Add to Cart') }}</x-primary-button>
            </div>
            
        </div>
    </div>

    <x-modal name="confirm-ticket-add" :show="$errors->theaterDeletion->isNotEmpty()" focusable>
            <form action="{{ route('cart.add') }}" id="multi-action-form" method="POST" class="ml-2">
                    @csrf
                <div class="m-4">
                    <input type="hidden" name="screening_id" value="{{ $screening->id }}">
                    <input type="hidden" name="seat_id" value="{{ $seat->id }}">
                    <input type="hidden" name="price" value="{{ $price }}">
                    <input type="hidden" name="redirect" id="redirect" value="">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('The Ticket has been addaed to cart') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('How do you wish to proceed?') }}
                </p>

                <div class="mt-6 flex justify-end ">
                    <button type="button" onclick="submitForm(1)" class="px-4 py-2 mx-2 font-semibold text-white bg-gray-500 rounded hover:bg-gray-400">
                        Continue Browsing
                    </button>
                    <button type="button" onclick="submitForm(0)" class="px-4 py-2 mx-2 font-semibold text-white bg-gray-500 rounded hover:bg-gray-400">
                        Go to Cart
                    </button>
                </div>
            </form>
        </x-modal>

        <script>
        function submitForm(redirectValue) {
            const form = document.getElementById('multi-action-form');
            const redirectInput = document.getElementById('redirect');
            redirectInput.value = redirectValue;
            form.submit();
        }
    </script>
@endsection