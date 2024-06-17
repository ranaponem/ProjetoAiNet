@extends('layouts.main')

@section('header-title', $screening->movie->title.': Select your seat')

@section('main')
    <div class="justify-center rounded flex bg-slate-700 pb-10">
        <div class="justify-center bg-slate-700 pb-10">
            <div class="rounded bg-slate-400  py-6 px-6 mx-1 mt-5 mb-6  text-center text-4xl">Screen is Here</div>
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
                    <div class="-mx-6 my-0 text-gray-400">{{ $seat->row }}</div>
                @endif
                {{-- Determine the style based on seat availability --}}
                @if ($seat_reserved)
                    <a class="rounded bg-yellow-600 cursor-not-allowed hover:bg-slate-200 lg:py-2 md:py-2 sm:py-1 lg:px-4 md:px-4 sm:px-3  mx-1 sm:mx-0.5 my-20"></a>
                @else
                    <a href="{{ route('tickets.create',['seat' => $seat,'screening' => $screening]) }}" class="rounded bg-slate-400 hover:bg-slate-200 lg:py-2 md:py-2 sm:py-1 lg:px-4 md:px-4 sm:px-3 mx-1 sm:mx-0.5 my-20"></a>
                @endif
            @endforeach
        </div>
    </div>
@endsection