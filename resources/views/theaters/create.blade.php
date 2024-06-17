@extends('layouts.main')

@section('header-title', 'Create new Theater')

@section('main')

    <form method="POST" action="{{ route('theaters.store') }}"
          enctype="multipart/form-data">
        @csrf
        <div class="mt-6 space-y-4 relative">

            <div class="p-6 sm:px-10 bg-gray-800 flex">
                <div class="grow w-2/3 mt-9 space-y-4 inline-block mr-10 mt-14">
                    <x-field.input name="name" label="Name"
                                   value="{{ old('name', $theater->name) }}"/>
                    <div class="inline-block mr-2">
                        <x-field.input name="rows" label="Rows (max. 26)"/></div>
                    <div class="inline-block mx-2">
                        <x-field.input name="cols" label="Cols (max. 26)"/></div>
                    <div class="flex items-center gap-4 absolute bottom-12">
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
                    
                </div>

                <div class="grow mt-9 space-y-4 inline-block pb-4">
                        <x-field.image
                            id="image_file"
                            name="image_file"
                            label="Theater Picture"
                            width="md"
                            height=""
                            deleteTitle="Delete"
                            :deleteAllow="$theater->getImageExistsAttribute()"
                            deleteForm="form_to_delete_image"
                            :imageUrl="$theater->getImageUrlAttribute()"
                        />
                    </div>
            </div>
            <!-- TODO Bruno -->
            
            
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