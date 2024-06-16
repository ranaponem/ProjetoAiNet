@extends('layouts.main')

@section('header-title', $screening->movie->title.': Select your seat')

@section('main')
    <div class="justify-center flex bg-slate-700 py-10">
        <div class="justify-center bg-slate-700 py-10">
            @foreach($screening->theater->seats as $seat)
                {{-- Check if the seat is already reserved --}}
                @php
                    $seat_reserved = false;
                    foreach ($tickets as $ticket) {
                        if ($ticket->seat_id == $seat->id) {
                            $seat_reserved = true;
                            break;
                        }
                    }
                @endphp
                {{-- Add line break after each row of seats --}}
                @if ($seat->seat_number==1)
                    <br><br><br>
                @endif
                {{-- Determine the style based on seat availability --}}
                @if ($seat_reserved)
                    <span class="bg-gray-400 rounded p-4 mx-1 my-20 cursor-not-allowed opacity-50">{{ $seat->seat_number }}</span>
                @else
                    <a href="{{ route('tickets.create',['seat' => $seat,'screening' => $screening]) }}" class="rounded bg-slate-400 hover:bg-slate-200 p-4 mx-1 my-20">{{ $seat->seat_number }}</a>
                @endif
            @endforeach
        </div>
    </div>
    <!-- debug
    <div>
        <h2>Tickets</h2>
        <ul>
            @foreach($screening->tickets as $ticket)
                <li class="text-white-50">Ticket ID: {{ $ticket->id }}, Seat: {{ $ticket->seat->row }} {{ $ticket->seat->seat_number }}</li>
            @endforeach
        </ul>
    </div>
    -->
@endsection
