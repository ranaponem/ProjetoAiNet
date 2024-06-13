<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden lg:table-cell">Abbreviation</th>
            <th class="px-2 py-2 text-left">Name</th>
            <th class="px-2 py-2 text-left">Type</th>
            <th class="px-2 py-2 text-right hidden sm:table-cell">Nº Semesters</th>
            <th class="px-2 py-2 text-right hidden sm:table-cell">Nº Places</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($courses as $course)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $course->abbreviation }}</td>
                <td class="px-2 py-2 text-left">{{ $course->name }}</td>
                <td class="px-2 py-2 text-left">{{ $course->type }}</td>
                <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $course->semesters }}</td>
                <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $course->places }}</td>
                @if($showView)
                    @can('view', $course)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                            href="{{ route('courses.show', ['course' => $course]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $course)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                            href="{{ route('courses.edit', ['course' => $course]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $course)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                            action="{{ route('courses.destroy', ['course' => $course]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
