@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<section>
    <header>
        <!-- Header content can be added here -->
    </header>
    <form method="post" action="{{ route('users.update'), ['user' => $user->id] }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="p-6 sm:px-10 bg-gray-800  w-96">
            <x-field.image
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
            <div class=" mt-4 flex">
                <x-button element="submit" type="dark" text="Upload Photo" class="uppercase"/>
            </div>
        </div>
    </form>
</section>
