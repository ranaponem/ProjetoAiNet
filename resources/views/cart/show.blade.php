@extends('layouts.main')

@section('header-title', 'Shopping Cart')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            @empty($cart)
                <h3 class="text-xl w-96 text-center">Cart is Empty</h3>
            @else
                <div class="mt-12">
                    <div class="flex justify-between space-x-12 items-end">
                        <div class="mt-8">
                            <h3 class="text-xl mb-4">Cart Items</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($cart as $item)
                                    @php
                                        // Assuming you have models and relationships set up correctly
                                        $screening = App\Models\Screening::find($item['screening_id']);
                                        $seat = App\Models\Seat::find($item['seat_id']);
                                        $movie = $screening->movie;
                                        $theater = $screening->theater;
                                        $price = $item['price'];
                                    @endphp

                                    <div class="text-black bg-gray-100 p-4 rounded-lg shadow">
                                        <p><strong>Movie:</strong> {{ $movie->title }}</p>
                                        <p><strong>Date:</strong> {{ $screening->date }}</p>
                                        <p><strong>Theater:</strong> {{ $theater->name }}</p>
                                        <p><strong>Screening Time:</strong> {{ $screening->start_time }}</p>
                                        <p><strong>Price:</strong> ${{ number_format($price, 2) }}</p>
                                        <p><strong>Seat:</strong> {{ $seat->seat_number }}{{ $seat->row }}</p>

                                        <!-- Form for removing item from cart -->
                                        <form action="{{ route('cart.remove') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="screening_id" value="{{ $screening->id }}">
                                            <input type="hidden" name="seat_id" value="{{ $seat->id }}">
                                            @method('DELETE') <!-- Ensure DELETE method -->
                                            <x-button element="submit" type="danger" text="Remove from Cart" class="mt-2"/>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div>
                        <!-- Form for clearing the entire cart -->
                        <form action="{{ route('cart.destroy') }}" method="post">
                            @csrf
                            @method('DELETE') <!-- Ensure DELETE method -->
                            <x-button element="submit" type="danger" text="Clear Cart" class="mt-4"/>
                        </form>
                    </div>
                </div>
            @endempty
        </div>
    </div>
@endsection
