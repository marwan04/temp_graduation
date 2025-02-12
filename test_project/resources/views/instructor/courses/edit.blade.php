@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
<div class="container mt-5">
    <h2 class="text-primary">✏️ Edit Course</h2>
    <a href="{{ route('courses.index') }}" class="btn btn-secondary mb-3">⬅ Back to Courses</a>

    <form action="{{ route('courses.update', $course->CourseID) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" name="CourseName" class="form-control" value="{{ $course->CourseName }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Credits</label>
            <input type="number" name="Credits" class="form-control" value="{{ $course->Credits }}" required>
        </div>
        <button type="submit" class="btn btn-primary">💾 Update Course</button>
    </form>
</div>
@endsection

