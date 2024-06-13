<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden sm:table-cell">Abbreviation</th>
            <th class="px-2 py-2 text-left">Name</th>
            @if($showCourse)
                <th class="px-2 py-2 text-left hidden md:table-cell">Course</th>
            @endif
            <th class="px-2 py-2 text-right hidden md:table-cell">Year</th>
            <th class="px-2 py-2 text-right hidden md:table-cell">Semester</th>
            <th class="px-2 py-2 text-right hidden lg:table-cell">ECTS</th>
            <th class="px-2 py-2 text-right hidden lg:table-cell">Hours</th>
            <th class="px-2 py-2 text-center hidden lg:table-cell">Optional</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
            @can('use-cart')
                @if($showAddToCart)
                    <th></th>
                @endif
                @if($showRemoveFromCart)
                    <th></th>
                @endif
            @endcan
        </tr>
        </thead>
        <tbody>
        @foreach ($disciplines as $discipline)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden sm:table-cell">{{ $discipline->abbreviation }}</td>
                <td class="px-2 py-2 text-left">{{ $discipline->name }}</td>
                @if($showCourse)
                    <td class="px-2 py-2 text-left hidden md:table-cell">{{ $discipline->courseRef->name }}</td>
                @endif
                <td class="px-2 py-2 text-right hidden md:table-cell">{{ $discipline->year }}</td>
                <td class="px-2 py-2 text-right hidden md:table-cell">{{ $discipline->semesterDescription }}</td>
                <td class="px-2 py-2 text-right hidden lg:table-cell">{{ $discipline->ECTS }}</td>
                <td class="px-2 py-2 text-right hidden lg:table-cell">{{ $discipline->hours }}</td>
                <td class="px-2 py-2 text-center hidden lg:table-cell">{{ $discipline->optional ? 'optional' : '' }}</td>
                @if($showView)
                    @can('view', $discipline)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                            href="{{ route('disciplines.show', ['discipline' => $discipline]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $discipline)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                            href="{{ route('disciplines.edit', ['discipline' => $discipline]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $discipline)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                            action="{{ route('disciplines.destroy', ['discipline' => $discipline]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @can('use-cart')
                    @if($showAddToCart)
                        <td>
                            <x-table.icon-add-cart class="px-0.5"
                                method="post"
                                action="{{ route('cart.add', ['discipline' => $discipline]) }}"/>
                        </td>
                    @endif
                    @if($showRemoveFromCart)
                        <td>
                            <x-table.icon-minus class="px-0.5"
                                method="delete"
                                action="{{ route('cart.remove', ['discipline' => $discipline]) }}"/>
                        </td>
                    @endif
                @endcan
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
