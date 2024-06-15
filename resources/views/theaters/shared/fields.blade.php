@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    
<div class="flex flex-wrap space-x-8 w-screen">
    <div class="grow mt-9 space-y-4">
        <x-field.input name="name" label="Name" :readonly="$readonly"
                        value="{{ old('name', $theater->name) }}"/>
    </div>
    <div class="pb-6">
        <x-field.image
            name="image_file"
            label="Theater Image"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Image"
            :deleteAllow="($mode == 'edit') && ($theater->getImageExistsAttribute())"
            deleteForm="form_to_delete_image"
            :imageUrl="$theater->getImageUrlAttribute()"
            />
    </div>
</div>
