<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index()
    {
        // $courses = Course::with('owner')->withCount('episodes')->get(); --> With directement intégré dans model

        $courses = Course::all();

        // dd($courses);

        return Inertia::render('Courses/Index', [
            'courses' => $courses
        ]);
    }

    public function show(int $id)
    {
        $course = Course::where('id', $id)->with('episodes')->first();

        return Inertia::render('Courses/Show', [
            'course' => $course
        ]);
    }
}
