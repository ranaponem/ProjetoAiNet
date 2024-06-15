@extends('layouts.main')

@section('header-title', 'Create new Theater')

@section('main')

<form method="POST" action="{{ route('theaters.update', ['theater' => $theater]) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mt-6 space-y-4">
        @include('theaters.shared.fields', ['mode' => 'edit'])
    </div>
    <div class="flex mt-6">
        <x-button element="submit" type="dark" text="Save theater" class="uppercase"/>
    </div>
</form>
<form class="hidden" id="form_to_delete_image"
    method="POST" action="{{ route('theaters.photo.destroy', ['theater' => $theater]) }}">
    @csrf
    @method('DELETE')
</form>
@endsection