@extends('layouts.main')

@section('header-title', 'Create new Theater')

@section('main')


    <div class="mt-6 space-y-4">
        @include('theaters.shared.fields', ['mode' => 'edit'])
    </div>

    <form class="hidden" id="form_to_delete_image"
          method="POST" action="{{ route('theaters.photo.destroy', ['theater' => $theater]) }}">
        @csrf
        @method('DELETE')
    </form>
@endsection
