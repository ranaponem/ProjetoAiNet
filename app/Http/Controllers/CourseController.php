<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CourseFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(): View
    {
        $allCourses = Course::orderBy('type')->orderBy('name')->paginate(20);

        return view('courses.index')->with('allCourses', $allCourses);
    }

    public function showCase(): View
    {
        return view('courses.showcase');
    }

    public function create(): View
    {
        $newCourse = new Course();
        return view('courses.create')->with('course', $newCourse);
    }

    public function store(CourseFormRequest $request): RedirectResponse
    {
        $newCourse = Course::create($request->validated());

        if ($request->hasFile('image_file')) {
            $request->image_file->storeAs('public/courses', $newCourse->fileName);
        }

        $url = route('courses.show', ['course' => $newCourse]);
        $htmlMessage = "Course <a href='$url'><u>{$newCourse->name}</u></a> ({$newCourse->abbreviation}) has been created successfully!";
        return redirect()->route('courses.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Course $course): View
    {
        return view('courses.edit')->with('course', $course);
    }

    public function update(CourseFormRequest $request, Course $course): RedirectResponse
    {
        $course->update($request->validated());

        if ($request->hasFile('image_file')) {
            if ($course->imageExists) {
                Storage::delete("public/courses/{$course->fileName}");
            }
            $request->image_file->storeAs('public/courses', $course->fileName);
        }

        $url = route('courses.show', ['course' => $course]);
        $htmlMessage = "Course <a href='$url'><u>{$course->name}</u></a> ({$course->abbreviation}) has been updated successfully!";
        return redirect()->route('courses.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Course $course): RedirectResponse
    {
        try {
            $url = route('courses.show', ['course' => $course]);
            $totalStudents = DB::scalar(
                'select count(*) from students where course = ?',
                [$course->abbreviation]);
            $totalDisciplines = DB::scalar(
                'select count(*) from disciplines where course = ?',
                [$course->abbreviation]);
            if ($totalStudents == 0 && $totalDisciplines == 0) {
                $course->delete();
                if ($course->imageExists) {
                    Storage::delete("public/courses/{$course->fileName}");
                }
                $alertType = 'success';
                $alertMsg = "Course {$course->name} ({$course->abbreviation}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $studentsStr = match(true) {
                    $totalStudents <= 0 => "",
                    $totalStudents == 1 => "there is 1 student enrolled in it",
                    $totalStudents > 1 => "there are $totalStudents students enrolled in it",
                };
                $disciplinesStr = match(true) {
                    $totalDisciplines <= 0 => "",
                    $totalDisciplines == 1 => "it already includes 1 discipline",
                    $totalDisciplines > 1 => "it already includes $totalDisciplines disciplines",
                };
                $justification = $studentsStr && $disciplinesStr
                    ? "$disciplinesStr and $studentsStr"
                    : "$disciplinesStr$studentsStr";
                $alertMsg = "Course <a href='$url'><u>{$course->name}</u></a> ({$course->abbreviation}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the course
                            <a href='$url'><u>{$course->name}</u></a> ({$course->abbreviation})
                            because there was an error with the operation!";
        }
        return redirect()->route('courses.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Course $course): View
    {
        return view('courses.show')->with('course', $course);
    }

    public function showCurriculum(Course $course): View
    {
        return view('courses.curriculum')->with('course', $course);
    }

    public function destroyImage(Course $course): RedirectResponse
    {
        if ($course->imageExists) {
            Storage::delete("public/courses/{$course->fileName}");
        }
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Image of course {$course->name} has been deleted.");
        return redirect()->back();
    }
}
