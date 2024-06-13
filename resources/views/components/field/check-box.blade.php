{{--
    NOTE: we've used the match to define multiple versions of width class,
    to ensure that all specific width related classes are defined statically
    on the source code - this guarantees that the Tailwind builder
    detects the corresponding class.
    If we had used dynamically generated classes (e.g. "w-{{ $width }}") then
    the builder would not detect concrete values.
    Check documentation about dynamic classes:
    https://tailwindcss.com/docs/content-configuration#dynamic-class-names
--}}
@php
    $widthClass = match($width) {
        'full' => 'w-full',
        'xs' => 'w-20',
        'sm' => 'w-32',
        'md' => 'w-64',
        'lg' => 'w-96',
        'xl' => 'w-[48rem]',
        '1/3' => 'w-1/3',
        '2/3' => 'w-2/3',
        '1/4' => 'w-1/4',
        '2/4' => 'w-2/4',
        '3/4' => 'w-3/4',
        '1/5' => 'w-1/5',
        '2/5' => 'w-2/5',
        '3/5' => 'w-3/5',
        '4/5' => 'w-4/5',
    };
@endphp
<div {{ $attributes->merge(['class' => "$widthClass"]) }}>
    <div class="flex py-5">
        <input name="{{ $name }}" type="hidden" value="0">
        <input id="id_{{ $name }}" name="{{ $name }}" type="checkbox"
            {{ $value ? 'checked' : '' }}
            value="1"
            class="appearance-none mt-0.5 w-5 h-5
                bg-white dark:bg-gray-900
                text-black dark:text-gray-50
                @error($name)
                    border-red-500 dark:border-red-500
                @else
                    border-gray-300 dark:border-gray-700
                @enderror
                focus:border-indigo-500 dark:focus:border-indigo-400
                focus:ring-indigo-500 dark:focus:ring-indigo-400
                shadow-sm
                disabled:text-gray-500
                disabled:opacity-100
                disabled:select-none"
                autofocus="autofocus"
                @required($required)
                @disabled($readonly)
            >
        <label class="ml-3 block font-normal text-base text-black dark:text-gray-50" for="id_{{ $name }}">
            {{ $label }}
        </label>
    </div>
    @error( $name )
        <div class="text-sm text-red-500 -mt-5">
            {{ $message }}
        </div>
    @enderror
</div>
