@extends('layouts.main')

@section('header-title', 'Create Tickets')

@section('main')
    <div class="container mx-auto mt-6">
        <h2 class="text-white text-2xl font-bold mb-4">Buy Ticket for {{ $screening->movie->title }}</h2>

        <div class="mb-4 text-white">
            <p><strong>Movie:</strong> {{ $screening->movie->title }}</p>
            <p><strong>Date:</strong> {{ $screening->date }}</p>
            <p><strong>Theater:</strong> {{ $screening->theater->name }}</p>
            <p><strong>Screening Time:</strong> {{ $screening->start_time }}</p>
            <p><strong>Price:</strong> {{ number_format($price, 2) }}€</p>
            <p><strong>Seat:</strong> {{ $seat->seat_number }}{{ $seat->row }}</p>
        </div>

        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="screening_id" value="{{ $screening->id }}">
            <input type="hidden" name="seat_id" value="{{ $seat->id }}">
            <input type="hidden" name="price" value="{{ $price }}">

            <button type="submit">Add to Cart</button>
        </form>
    </div>
@endsection
