<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('instructor.courses.index', compact('courses'));  // ✅ Fixed Path
    }

    public function create()
    {
        return view('instructor.courses.create'); // ✅ Fixed Path
    }

    public function store(Request $request)
    {
        $request->validate([
            'CourseName' => 'required|string|max:255',
            'Credits' => 'required|integer|min:1',
        ]);

        Course::create($request->all());

        return redirect()->route('instructor.courses')->with('success', 'Course created successfully!'); // ✅ Fixed Route
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('instructor.courses.edit', compact('course')); // ✅ Fixed Path
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'CourseName' => 'required|string|max:255',
            'Credits' => 'required|integer|min:1',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->all());

        return redirect()->route('instructor.courses')->with('success', 'Course updated successfully!'); // ✅ Fixed Route
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('instructor.courses')->with('success', 'Course deleted successfully!'); // ✅ Fixed Route
    }
}

