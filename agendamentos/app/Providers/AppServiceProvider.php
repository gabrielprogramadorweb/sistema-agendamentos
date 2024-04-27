<?php

namespace App\Providers;

use App\Services\CalendarService;
use App\Services\ConcreteCalendarService;
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
        //
    }
}
