@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<section>
    <header>
        <!-- Header content can be added here -->
    </header>
    <form id="profile-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="p-6 sm:px-10 bg-white dark:bg-gray-800 w-96">
            <x-field.image
                id="image_file"
                name="image_file"
                label="User Image"
                width="md"
                height=""
                :readonly="$readonly"
                deleteTitle="Delete"
                :deleteAllow="($mode == 'edit') && ($user->getImageExistsAttribute())"
                deleteForm="form_to_delete_image"
                :imageUrl="$user->getImageUrlAttribute()"
            />
        </div>
    </form>
    <form class="hidden" id="form_to_delete_image"
          method="POST" action="{{ route('users.photo.destroy', ['user' => $user]) }}">
        @csrf
        @method('DELETE')
    </form>


    <!-- JavaScript to automatically submit the form when a new photo is selected -->
    <script>
        document.getElementById('image_file').addEventListener('change', function() {
            document.getElementById('profile-form').submit();
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
</section>