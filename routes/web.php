<?php

use App\Http\Controllers\CoursesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');

/** Route demandent à être connecté */
Route::group(['auth:sanctum', 'verified'], function () {
    Route::get('/courses/{id}', [CoursesController::class, 'show'])->name('courses.show');

    Route::post('/toggleProgress', [CoursesController::class, 'toggleProgress'])->name('courses.toggle');

    Route::post('/courses', [CoursesController::class, 'store'])->name('courses.store');

    Route::get('/dashboard', function () {
        return Inertia\Inertia::render('Dashboard');
    })->name('dashboard');
});
