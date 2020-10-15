<?php

namespace App\Providers;

use App\Youtube\YoutubeServices;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Init flash message success
        Inertia::share('flash', function () {
            return [
                'success' => Session::get('success'),
            ];
        });

        Inertia::share([
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
        ]);

        // Lorsque mon YoutubeServices est instancié (voir CoursesController) je déclare ici l'api key afin que Laravel sache qu'il doit l'utiliser
        $this->app->singleton('App\Youtube\YoutubeServices', function() {
            // Dans le constructeur je veux récupérer mon YOUTUBE_API_KEY
            return new YoutubeServices(env('YOUTUBE_API_KEY'));
        });
    }
}
