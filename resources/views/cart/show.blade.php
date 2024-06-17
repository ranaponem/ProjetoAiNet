@extends('layouts.main')

@section('header-title', 'Shopping Cart')

@section('main')
    @php
        $total=0;
        foreach ($cart as $item) {
            $total += $item['price'];
        }
    @endphp

    <div class="flex justify-center w-full">
        <div class="w-full my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden  sm:rounded-lg text-gray-900 dark:text-gray-50">
            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        {{ __('Whoops! Something went wrong.') }}
                    </div>

                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @empty($cart)
                <h3 class="text-xl w-96 text-center">Cart is Empty</h3>
            @else
                <div class="w-full">
                    
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        <div class="w-full">
                            <h3 class="text-xl mb-3">Cart Items</h3>
                            <div class="">
                                @foreach ($cart as $item)
                                    @php
                                        $screening = App\Models\Screening::find($item['screening_id']);
                                        $seat = App\Models\Seat::find($item['seat_id']);
                                        $movie = $screening->movie;
                                        $theater = $screening->theater;
                                        $price = $item['price'];
                                    @endphp

                                    <div class="text-gray-400 bg-gray-100 dark:bg-gray-800 -mt-1 rounded-lg shadow p-10">
                                        <div class="flex">
                                            <div>
                                                <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="text-2xl text-gray-800 dark:text-gray-300 hover:text-gray-400 dark:hover:text-gray-50">
                                                    <img class="h-40 inline-block mr-10 rounded" src="{{ $movie->getImageUrlAttribute() }}" alt="{{ $movie->poster_filename }}">
                                                </a>
                                            </div>
                                            <div class="w-5/6">
                                                <div class="flex justify-between">
                                                    <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="text-2xl text-gray-800 dark:text-gray-300 hover:text-gray-400 dark:hover:text-gray-50"><strong>Movie:</strong> {{ $movie->title }}</a>
                                                    <form action="{{ route('cart.remove') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="screening_id" value="{{ $screening->id }}">
                                                        <input type="hidden" name="seat_id" value="{{ $seat->id }}">
                                                        @method('DELETE') <!-- Ensure DELETE method -->
                                                        <x-button element="submit" type="danger" text="Remove" class="mt-2" />
                                                    </form>
                                                </div>
                                                <p><strong>Date:</strong> {{ $screening->date }}</p>
                                                <p><strong>Screening Time:</strong> {{ $screening->start_time }}</p>
                                                <p><strong>Theater:</strong> {{ $theater->name }}</p>
                                                <div class="flex justify-between mb-12">
                                                    <p ><strong>Seat:</strong> {{ $seat->seat_number }}{{ $seat->row }}</p>
                                                    <p class="text-gray-800 dark:text-gray-400"><strong>${{ number_format($price, 2) }}</strong></p>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="inline-block w-full h-full">
                            <h3 class="text-xl mb-2">Summary</h3>
                            <div class=" text-gray-800 dark:text-gray-400 text-lg bg-gray-100 dark:bg-gray-800 rounded-lg   p-10">
                                @foreach ($cart as $item)
                                        @php
                                        $screening = App\Models\Screening::find($item['screening_id']);
                                        $seat = App\Models\Seat::find($item['seat_id']);
                                        $movie = $screening->movie;
                                        $theater = $screening->theater;
                                        $price = $item['price'];
                                        
                                    @endphp

                                    
                                        <p class="mb-10"><strong>Ticket for '{{ $movie->title }}' ({{$theater->name}} {{$seat->row}}{{$seat->seat_number}}):</strong><br> ${{ number_format($price, 2) }}</p>
                                    
                                    
                                @endforeach
                                <hr>
                                <div class="flex justify-between"><h3 class="text-2xl text-gray-800 dark:text-gray-300 mb-3 mt-6 py-3">Sub-Total: </h3><h3 class="text-2xl text-gray-800 dark:text-gray-300 my-5 pb-2 pt-4">${{ number_format($total, 2) }}</h3></div>
                                
                            </div>
                            <div class="flex justify-between w-full">
                                <div>
                                    <!-- Form for clearing the entire cart -->
                                    <form action="{{ route('cart.destroy') }}" method="post">
                                        @csrf
                                        @method('DELETE') <!-- Ensure DELETE method -->
                                        <x-button element="submit" type="danger" text="Clear Cart" class="mt-4" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="w-full grid grid-cols-1 mt-8 text-gray-800 dark:text-gray-400  bg-gray-100 dark:bg-gray-800 p-10 pb-2 rounded-lg shadow">
                                <h3 class="text-2xl text-gray-800 dark:text-gray-300     mb-4">Client Information</h3>
                                <form action="{{ route('purchases.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="cart" value="{{ json_encode($cart) }}">
                                        <input type="hidden" name="total_price" value="{{ $total }}">
                                        <input type="hidden" name="customer_id" value="{{ auth()->user()->customer->id }}">
                                        <input type="hidden" name="payment_type" value="{{ auth()->user()->customer->payment_type }}">
                                        <input type="hidden" name="payment_ref" value="{{ auth()->user()->customer->payment_ref }}">
                                        <input type="hidden" name="nif" value="{{ auth()->user()->customer->nif }}">
                                        <input type="hidden" name="customer_name" value="{{ auth()->user()->name }}">
                                        <input type="hidden" name="customer_email" value="{{ auth()->user()->email }}">
                                        <!--create a date field with today's date-->
                                        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                                    <div class="mb-4 grid lg:grid-cols-3 sm:grid-cols-1"> 
                                        <div class="inline-block mx-4">
                                            <div class="w-full flex">
                                                <strong class="mt-3 mr-3">Name:</strong>
                                                <x-text-input id="customer_name" name="customer_name" type="text" class="mt-1 block w-full" :value="auth()->user()->name " required autocomplete="customer_name" />
                                                <x-input-error class="mt-2" :messages="$errors->get('customer_name')" />
                                            </div>
                                            <div class="w-full flex">
                                                <strong class="mt-3 mr-4">Email:</strong>
                                                <x-text-input id="customer_email" name="customer_email" type="text" class="mt-1 block w-full" :value="auth()->user()->email  " required autocomplete="customer_email" />
                                                <x-input-error class="mt-2" :messages="$errors->get('customer_email')" />
                                            </div>
                                            <div class="h-full lg:mt-10 md:mt-10 sm:mt-6 sm:mb-6 flex">
                                                <a class="underline text-gray-400"href="{{ route('profile.edit') }}">
                                                    Something wrong?
                                                </a>
                                            </div>
                                            </div>
                                            <div class="mx-4">
                                                <div class="w-full flex">
                                                    <strong class="mt-3 mr-3 w-48">Payment Type:</strong>
                                                    <x-text-input id="payment_type" name="payment_type" type="text" class="mt-1 block w-full" :value="auth()->user()->customer->payment_type  " required autocomplete="payment_type" />
                                                    <x-input-error class="mt-2" :messages="$errors->get('payment_type')" />
                                                </div>
                                                <div class="w-full flex">
                                                    <strong class="mt-3 mr-3 w-48">Payment Ref:</strong>
                                                    <x-text-input id="payment_ref" name="payment_ref" type="text" class="mt-1 block w-full" :value="auth()->user()->customer->payment_ref  " required autocomplete="payment_ref" />
                                                    <x-input-error class="mt-2" :messages="$errors->get('payment_ref')" />
                                                </div>
                                                <div class="w-full flex">
                                                    <strong class="mt-3 mr-3 w-48">NIF:</strong>
                                                    <x-text-input id="nif" name="nif" type="text" class="mt-1 block w-full" :value="auth()->user()->customer->nif  " required autocomplete="nif" />
                                                    <x-input-error class="mt-2" :messages="$errors->get('nif')" />
                                                </div>
                                            </div>
                                            <div class="h-full mt-28 flex justify-end">
                                                
                                                <x-button element="submit" type="primary" text="Continue to Checkout" class="mt-4" />
                                            </div>
                                            
                                        </div>
                                    </div>
                                </form>
                        </div> 
                    
                   
                </div>
            @endempty
        </div>
    </div>
@endsection