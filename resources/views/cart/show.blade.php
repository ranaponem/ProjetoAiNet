@extends('layouts.main')

@section('header-title', 'Shopping Cart')

@section('main')
    @php
        $total=0;
        foreach ($cart as $item) {
            $total += $item['price'];
        }
    @endphp

    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
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
                <div class="mt-12">
                    <div class="flex justify-between space-x-12 items-end">
                        <div class="mt-8">
                            <h3 class="text-xl mb-4">Client Information</h3>
                            <div class="mb-4">
                                <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                <p><strong>Payment Type:</strong>{{ auth()->user()->customer->payment_type }}</p>
                                <p><strong>Payment Ref:</strong>{{ auth()->user()->customer->payment_ref }}</p>
                                <p><strong>NIF:</strong>{{ auth()->user()->customer->nif }}</p>
                                <p><strong>Total:</strong> {{ $total }}€</p>
                                <a href="{{ route('profile.edit') }}" class="href">Something wrong?</a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-xl mb-4">Cart Items</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($cart as $item)
                                @php
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
                                        <x-button element="submit" type="danger" text="Remove from Cart" class="mt-2" />
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-8">
                        <!-- Form to submit cart items to purchase creation -->
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
                            <x-button element="submit" type="primary" text="Continue to Checkout" class="mt-4" />
                        </form>
                    </div>
                    <div>
                        <!-- Form for clearing the entire cart -->
                        <form action="{{ route('cart.destroy') }}" method="post">
                            @csrf
                            @method('DELETE') <!-- Ensure DELETE method -->
                            <x-button element="submit" type="danger" text="Clear Cart" class="mt-4" />
                        </form>
                    </div>
                </div>
            @endempty
        </div>
    </div>
@endsection
