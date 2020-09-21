<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    public function index()
    {

        $courses = Course::with('owner')->select('courses.*', DB::raw(
            '(SELECT COUNT(DISTINCT(user_id))
            FROM completions
            INNER JOIN episodes ON completions.episode_id = episodes.id
            WHERE episodes.course_id = courses.id
            ) AS participants'
        ))->withCount('episodes')->latest()->get();

        // With directement intégré dans le model
        // $courses = Course::all();

        // dd($courses);

        return Inertia::render('Courses/Index', [
            'courses' => $courses
        ]);
    }

    public function show(int $id)
    {
        $course = Course::where('id', $id)->with('episodes')->first();

        $watched = auth()->user()->watchedEpisodes;

        return Inertia::render('Courses/Show', [
            'course' => $course,
            'watched' => $watched
        ]);
    }

    /**
     * Enregistrement en BDD d'un épisode marqué comme "vu"
     */
    public function toggleProgress(Request $request)
    {
        $id = $request->input('episodeId');
        $user = auth()->user();

        // Toggle va attacher ou détacher automatiquement l'id à la table 
        $user->watchedEpisodes()->toggle($id);

        return $user->watchedEpisodes;
    }
}
