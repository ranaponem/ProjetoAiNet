<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">Name</th>
            @if($showDepartment)
                <th class="px-2 py-2 text-left hidden lg:table-cell">Department</th>
            @endif
            <th class="px-2 py-2 text-left hidden md:table-cell">Email</th>
            <th class="px-2 py-2 text-left hidden xl:table-cell">Office</th>
            <th class="px-2 py-2 text-right hidden xl:table-cell">Extension</th>
            <th class="px-2 py-2 text-left hidden xl:table-cell">Locker</th>
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
        @foreach ($teachers as $teacher)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $teacher->user->name }}</td>
                @if($showDepartment)
                    <td class="px-2 py-2 text-left hidden lg:table-cell">{{ $teacher?->departmentRef?->name }}</td>
                @endif
                <td class="px-2 py-2 text-left hidden md:table-cell">{{ $teacher->user->email }}</td>
                <td class="px-2 py-2 text-left hidden xl:table-cell">{{ $teacher->office }}</td>
                <td class="px-2 py-2 text-right hidden xl:table-cell">{{ $teacher->extension }}</td>
                <td class="px-2 py-2 text-left hidden xl:table-cell">{{ $teacher->locker }}</td>
                <td class="px-2 py-2 text-center hidden xl:table-cell">{{ $teacher->user->admin ? 'Yes' : '-' }}</td>
                @if($showView)
                    @can('view', $teacher)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                            href="{{ route('teachers.show', ['teacher' => $teacher]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $teacher)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                            href="{{ route('teachers.edit', ['teacher' => $teacher]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $teacher)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                            action="{{ route('teachers.destroy', ['teacher' => $teacher]) }}"/>
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
