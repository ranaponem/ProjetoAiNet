<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">
                <div>
                    <x-field.select name="course" label="Course"
                        value="{{ $course }}"
                        :options="$listCourses"/>
                </div>
                <div class="flex space-x-3">
                    <x-field.select name="year" label="Year"
                        value="{{ $year }}"
                        :options="$listYears"/>
                    <x-field.select name="semester" label="Semester"
                        value="{{ $semester }}"
                        :options="$listSemesters"/>
                </div>
                <div>
                    <x-field.input name="teacher" label="Teacher" class="grow"
                        value="{{ $teacher }}"/>
                </div>
            </div>
            <div class="grow-0 flex flex-col space-y-3 justify-start">
                <div class="pt-6">
                    <x-button element="submit" type="dark" text="Filter"/>
                </div>
                <div>
                    <x-button element="a" type="light" text="Cancel" :href="$resetUrl"/>
                </div>
            </div>
        </div>
    </form>
</div>
