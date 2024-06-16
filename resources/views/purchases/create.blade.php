@extends('layouts.main')

@section('header-title', 'Create New Purchase')

@section('main')
    @php
        $user = auth()->user();
        $customer = $user->customer; // Assuming there is a relationship between User and Customer models
    @endphp

    <div class="flex justify-center">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Main content area -->
            <div class="col-span-2 my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                        shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
                <h3 class="text-2xl mb-6">New Purchase</h3>

                <form action="{{ route('purchases.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Customer ID (if applicable) -->
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                    <!-- Purchase Date -->
                    <div class="mb-4 hidden">
                        <label for="date" class="block text-sm font-medium text-gray-300">Purchase Date</label>
                        <input type="date" name="date" id="date" class="text-black mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                               value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>

                    <!-- Total Price -->
                    <div class="mb-4">
                        <label for="total_price" class="block text-sm font-medium text-gray-300">Total Price in €</label>
                        <input readonly value="{{ $total }}" type="number" name="total_price" id="total_price" class="text-black mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" step="0.01" min="0" required>
                    </div>

                    <!-- Customer Name -->
                    <div class="mb-4">
                        <label for="customer_name" class="block text-sm font-medium text-gray-300">Customer Name</label>
                        <input readonly type="text" name="customer_name" id="customer_name" class="text-black mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $user->name }}" required>
                    </div>

                    <!-- Customer Email -->
                    <div class="mb-4">
                        <label for="customer_email" class="block text-sm font-medium text-gray-300">Customer Email</label>
                        <input readonly type="email" name="customer_email" id="customer_email" class="text-black mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $user->email }}" required>
                    </div>

                    <!-- NIF (Optional) -->
                    <div class="mb-4">
                        <label for="nif" class="block text-sm font-medium text-gray-300">NIF (Optional)</label>
                        <input readonly value="{{ $customer->nif }}" type="text" name="nif" id="nif" class="text-black mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <!-- Payment Type -->
                    <div class="mb-4">
                        <label for="payment_type" class="block text-sm font-medium text-gray-300">Payment Reference</label>
                        <input readonly value="{{ $customer->payment_type }}" type="text" name="payment_type" id="payment_type" class="text-black mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <!-- Payment Reference -->
                    <div class="mb-4">
                        <label for="payment_ref" class="block text-sm font-medium text-gray-300">Payment Reference</label>
                        <input readonly value="{{ $customer->payment_ref }}" type="text" name="payment_ref" id="payment_ref" class="text-black mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <x-button element="submit" type="primary" text="Create Purchase" class="mt-4"/>
                    </div>
                </form>
            </div>

            <!-- Sidebar for displaying tickets -->
            <div class="col-span-1">
                <div class="p-4 bg-gray-100 rounded-lg shadow">
                    <h3 class="text-xl mb-4">Tickets</h3>
                    @foreach ($tickets as $index => $item)
                        @php
                            $screening = App\Models\Screening::find($item['screening_id']);
                            $seat = App\Models\Seat::find($item['seat_id']);
                            $movie = $screening->movie;
                            $theater = $screening->theater;
                            $price = $item['price'];
                        @endphp

                        <div class="mb-4">
                            <p><strong>Ticket {{ $index + 1 }}</strong></p>
                            <p><strong>Movie:</strong> {{ $movie->title }}</p>
                            <p><strong>Date:</strong> {{ $screening->date }}</p>
                            <p><strong>Theater:</strong> {{ $theater->name }}</p>
                            <p><strong>Screening Time:</strong> {{ $screening->start_time }}</p>
                            <p><strong>Price:</strong> {{ number_format($price, 2) }}€</p>
                            <p><strong>Seat:</strong> {{ $seat->seat_number }}{{ $seat->row }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
