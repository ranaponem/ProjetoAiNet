@extends('layouts.main')

@section('header-title', 'Purchase Details')

@section('main')
    <div class="container mx-auto my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <h2 class="text-2xl font-semibold mb-6">Purchase Details</h2>

        <div class="mb-4">
            <p><strong>Date:</strong> {{ $purchase->date }}</p>
            <p><strong>Total Price:</strong> €{{ number_format($purchase->total_price, 2) }}</p>
            <p><strong>Payment Type:</strong> {{ $purchase->payment_type }}</p>
            <p><strong>Payment Ref:</strong> {{ $purchase->payment_ref }}</p>
            <p><strong>NIF:</strong> {{ $purchase->nif }}</p>
        </div>

        <h3 class="text-xl font-semibold mb-4">Tickets</h3>

        @if ($purchase->tickets->isEmpty())
            <p>No tickets found for this purchase.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($purchase->tickets as $ticket)
                    <div class="p-4 bg-gray-100 rounded-lg shadow">
                        <p><strong>Movie:</strong> {{ $ticket->screening->movie->title }}</p>
                        <p><strong>Date:</strong> {{ $ticket->screening->date }}</p>
                        <p><strong>Theater:</strong> {{ $ticket->screening->theater->name }}</p>
                        <p><strong>Screening Time:</strong> {{ $ticket->screening->start_time }}</p>
                        <p><strong>Seat:</strong> {{ $ticket->seat->seat_number }}{{ $ticket->seat->row }}</p>
                        <p><strong>Price:</strong> €{{ number_format($ticket->price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('purchases.index') }}" class="text-blue-600 hover:underline mt-4 block">Back to Purchases</a>
    </div>
@endsection
