<?php

namespace App\Providers;

use App\Services\CalendarService;
use App\Services\ConcreteCalendarService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(CalendarService::class, ConcreteCalendarService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Compose all the views
        View::composer('*', function ($view) {
            $user = Auth::user();
            $imageUrl = asset('front/assets/default-profile.png'); // Default image

            if ($user && $user->profile_image && Storage::exists('public/' . $user->profile_image)) {
                $imageUrl = asset('storage/' . $user->profile_image);
            }

            $view->with('imageUrl', $imageUrl);
        });
    }
}
