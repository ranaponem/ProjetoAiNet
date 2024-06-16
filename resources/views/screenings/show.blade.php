@extends('layouts.main')

@section('header-main', $screening->movie->title . ' - Your Seat')

@section('main')
    <div class="seat-matrix">
        @php
            $seats = $screening->theater->seats;
            $rows = $seats->groupBy('row_number');
        @endphp

        @foreach($rows as $rowNumber => $rowSeats)
            <div class="seat-row">
                <span class="row-label">Row {{ $rowNumber }}</span>
                @foreach($rowSeats as $seat)
                    <div class="seat">
                        Seat {{ $seat->seat_number }}
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
