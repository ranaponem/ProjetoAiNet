<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
            <tr>
                <th class="border-2 border-gray-400 dark:border-gray-500 py-1 px-3 bg-gray-100 dark:bg-gray-800">Year</th>
                <th class="py-1 px-3 border-y-2 border-e-2 border-y-gray-400 dark:border-y-gray-500 border-e-gray-400 dark:border-e-gray-500 bg-gray-100 dark:bg-gray-800">1st semester</th>
                <th class="py-1 px-3 border-y-2 border-e-2 border-y-gray-400 dark:border-y-gray-500 border-e-gray-400 dark:border-e-gray-500 bg-gray-100 dark:bg-gray-800">2nd semester</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($curriculum as $year => $rowsYear)
                @foreach ($rowsYear as $row)
                    <tr>
                        @php
                            $lastRowOfYear = $loop->last;
                        @endphp
                        @if ($loop->first)
                            <th class="py-1 px-3 border-b-2 border-x-2 border-b-gray-400 dark:border-b-gray-500
                                        border-x-gray-400 dark:border-x-gray-500
                                        bg-gray-100 dark:bg-gray-800"
                                rowspan="{{ count($rowsYear)}}">
                                {{ $year }}
                            </th>
                        @endif
                        @foreach ($row as $semesterCell)
                            @if($semesterCell)
                                @if($semesterCell['rowspan'] || $lastRowOfYear)
                                    <td class="py-1 px-3 text-sm
                                            border border-b-2 border-b-gray-400 dark:border-b-gray-500
                                            border-e-2 border-e-gray-400 dark:border-e-gray-500
                                            @if($semesterCell['discipline']?->semester === 0) text-center @endif
                                            "
                                        @if($semesterCell['colspan']) colspan={{$semesterCell['colspan']}} @endif
                                        @if($semesterCell['rowspan']) rowspan={{$semesterCell['rowspan']}} @endif
                                    >
                                        @if($semesterCell['discipline'])
                                            @can('view', $semesterCell['discipline'])
                                                <a href="{{ route('disciplines.show', ['discipline' =>$semesterCell['discipline']])}}">
                                                    {{ $semesterCell['discipline']->name }}
                                                </a>
                                            @else
                                                 {{ $semesterCell['discipline']->name }}
                                            @endcan
                                        @endif
                                    </td>
                                @else
                                    <td class="py-1 px-3 text-sm
                                                border border-b-gray-300 dark:border-b-gray-700
                                                border-e-2 border-e-gray-400 dark:border-e-gray-500
                                                @if($semesterCell['discipline']?->semester === 0) text-center @endif"
                                        @if($semesterCell['colspan']) colspan={{$semesterCell['colspan']}} @endif
                                        @if($semesterCell['rowspan']) rowspan={{$semesterCell['rowspan']}} @endif
                                    >
                                        @if($semesterCell['discipline'])
                                            @can('view', $semesterCell['discipline'])
                                                <a href="{{ route('disciplines.show', ['discipline' =>$semesterCell['discipline']])}}">
                                                    {{ $semesterCell['discipline']->name }}
                                                </a>
                                            @else
                                                 {{ $semesterCell['discipline']->name }}
                                            @endcan
                                        @endif
                                    </td>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
