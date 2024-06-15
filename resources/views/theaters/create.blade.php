@extends('layouts.main')

@section('header-title', 'Create new Theater')

@section('main')



@endsection
@extends('layouts.main')

@section('header-title', 'Create new Theater')

@section('main')

<form method="POST" action="{{ route('theaters.store') }}"
    enctype="multipart/form-data">
    @csrf
    <div class="mt-6 space-y-4">
        @include('theaters.shared.fields', ['mode' => 'create'])
    </div>
    <div class="flex mt-6">
        <x-button element="submit" type="dark" text="Save new theater" class="uppercase"/>
    </div>
</form>
@endsection
