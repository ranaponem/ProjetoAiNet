<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">Name</th>
            <th class="px-2 py-2 text-left hidden lg:table-cell">Email</th>
            <th class="px-2 py-2 text-center hidden xl:table-cell">Adm.</th>
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
        @foreach ($administratives as $administrative)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $administrative->name }}</td>
                <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $administrative->email }}</td>
                <td class="px-2 py-2 text-center hidden xl:table-cell">{{ $administrative->admin ? 'Yes' : '-' }}</td>
                @if($showView)
                    @can('view', $administrative)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                            href="{{ route('administratives.show', ['administrative' => $administrative]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $administrative)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                            href="{{ route('administratives.edit', ['administrative' => $administrative]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $administrative)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                            action="{{ route('administratives.destroy', ['administrative' => $administrative]) }}"/>
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
