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
    $selectedValue = array_key_exists($value, $options) ? $value : $defaultValue;
@endphp
<div {{ $attributes->merge(['class' => "$widthClass"]) }}>
    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="id_{{ $name }}">
        {{ $label }}
    </label>
    <select id="id_{{ $name }}" name="{{ $name }}"
        class="appearance-none block
            mt-1 w-full
            bg-white dark:bg-gray-900
            text-black dark:text-gray-50
            @error($name)
                border-red-500 dark:border-red-500
            @else
                border-gray-300 dark:border-gray-700
            @enderror
            focus:border-indigo-500 dark:focus:border-indigo-400
            focus:ring-indigo-500 dark:focus:ring-indigo-400
            rounded-md shadow-sm
            disabled:rounded-none disabled:shadow-none
            disabled:border-t-transparent disabled:border-x-transparent
            disabled:border-dashed
            disabled:bg-none
            disabled:opacity-100
            disabled:select-none"
            autofocus="autofocus"
            @required($required)
            @disabled($readonly)
        >
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" @selected($selectedValue == $key)>{{ $value }}</option>
        @endforeach
    </select>
    @error( $name )
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
