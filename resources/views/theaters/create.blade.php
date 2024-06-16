@extends('layouts.main')

@section('header-title', 'Create new Theater')

@section('main')

    <form method="POST" action="{{ route('theaters.store') }}"
          enctype="multipart/form-data">
        @csrf
        <div class="mt-6 space-y-4">

            <div class="p-6 sm:px-10 bg-gray-800 flex">
                <div class="grow w-2/3 mt-9 space-y-4 inline-block mr-10">
                    <x-field.input name="name" label="Name"
                                   value="{{ old('name', $theater->name) }}"/>
                </div>
                <div class="grow mt-9 space-y-4 inline-block pb-4">
                    <x-field.image
                        id="image_file"
                        name="image_file"
                        label="Theater Picture"
                        width="md"
                        height=""


                        :imageUrl="$theater->photo_filename ? asset('storage/photos/' . $theater->photo_filename) : 'storage/photos/475_666c4e5ed23f0.jpg'"
                    />
                </div>
            </div>
            <!-- TODO Bruno -->
            <div class="grow w-2/3 mt-9 space-y-4 inline-block mr-10">
                <x-field.input name="rows" label="Rows"/>
                <x-field.input name="cols" label="Cols"/>
            </div>
            <div class="flex items-center gap-4 ">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'theater-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
    </form>

    </div>
    </form>
@endsection
<!-- JavaScript to automatically submit the form when a new photo is selected -->
<script>
    document.getElementById('image_file').addEventListener('change', function() {
        document.getElementById('theater-form').submit();
    });
</script>
<script>
    // Function to submit delete form when delete button is clicked
    function deletePhoto() {
        document.getElementById('form_to_delete_image').submit();
    }

    // Listen for click on delete button
    document.getElementById('delete-button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission
        deletePhoto(); // Call delete function
    });
</script>
