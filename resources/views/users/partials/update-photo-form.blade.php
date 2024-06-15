@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<section>
    <header>
        <!-- Header content can be added here -->
    </header>
    <form id="profile-form" method="post" action="{{ route('users.update', ['user' => $user->id]) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="p-6 sm:px-10 bg-gray-800 w-96">
            <x-field.image
                id="image_file"
                name="image_file"
                label="User Image"
                width="md"
                height=""
                :readonly="$readonly"
                deleteTitle="Delete Image"
                :deleteAllow="($mode == 'edit') && ($user->getImageExistsAttribute())"
                deleteForm="form_to_delete_image"
                :imageUrl="$user->getImageUrlAttribute()"
            />
        </div>
    </form>

    <!-- JavaScript to automatically submit the form when a new photo is selected -->
    <script>
        document.getElementById('image_file').addEventListener('change', function() {
            document.getElementById('profile-form').submit();
        });
    </script>
</section>
