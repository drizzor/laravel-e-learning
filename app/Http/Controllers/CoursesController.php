<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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

        // dd($course->id);

        return Inertia::render('Courses/Show', [
            'course' => $course,
            'watched' => $watched
        ]);
    }

    /**
     * Enregistre un nouveau cours dans la BDD
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'episodes' => ['required', 'array'],
            'episodes.*.title' => 'required',
            'episodes.*.description' => 'required',
            'episodes.*.video_url' => 'required',
        ]);

        // L'appel de create va faire appelle à ma méthode booted située dans le model Course
        $course = Course::create($request->all());

        // Récupération des épisodes
        foreach ($request->input('episodes') as $episode) {
            $episode['course_id'] = $course->id;
            Episode::create($episode);
        }

        return Redirect::route('dashboard')->with('success', 'Félicitation, la formation a bien été mise en ligne.');
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
