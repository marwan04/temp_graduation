<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Course;
use App\Models\Instructor;

class SectionController extends Controller
{
    /**
     * Display a listing of the sections.
     */
    public function index()
    {
        $sections = Section::with(['course', 'instructor'])->get();
        return view('instructor.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new section.
     */
    public function create()
    {
        $courses = Course::all(); // ✅ Fetch all courses
        $instructors = Instructor::all(); // ✅ Fetch all instructors

        return view('instructor.sections.create', compact('courses', 'instructors'));
    }

    /**
     * Store a newly created section in the database.
     */
    public function store(Request $request)
    {
        // ✅ Validate the request
        $request->validate([
            'semester' => 'required|string|max:20',
            'year' => 'required|integer|min:2020',
            'course_id' => 'required|exists:Course,CourseID',  // ✅ Ensure table name is correct
            'instructor_id' => 'required|exists:Instructor,InstructorID',
        ]);

        // ✅ Create the section
        Section::create([
            'Semester' => $request->input('semester'),
            'Year' => $request->input('year'),
            'CourseID' => $request->input('course_id'),
            'InstructorID' => $request->input('instructor_id'),
        ]);

        return redirect()->route('admin.sections.index')->with('success', 'Section created successfully!');
    }

    /**
     * Show the form for editing a section.
     */
    public function edit(Section $section)
    {
        $courses = Course::all();
        $instructors = Instructor::all();
        return view('instructor.sections.edit', compact('section', 'courses', 'instructors'));
    }

    /**
     * Update an existing section.
     */
    public function update(Request $request, Section $section)
    {
        $request->validate([
            'semester' => 'required|string|max:20',
            'year' => 'required|integer|min:2020',
            'course_id' => 'required|exists:Course,CourseID',
            'instructor_id' => 'required|exists:Instructor,InstructorID',
        ]);

        $section->update([
            'Semester' => $request->input('semester'),
            'Year' => $request->input('year'),
            'CourseID' => $request->input('course_id'),
            'InstructorID' => $request->input('instructor_id'),
        ]);

        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully!');
    }

    /**
     * Remove the section.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success', 'Section deleted successfully!');
    }
}
