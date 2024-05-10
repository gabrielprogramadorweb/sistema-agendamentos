<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SendGridServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving('mailer', function ($mailer) {
            $mailer->extend('sendgrid', function ($config) {
                $client = new \SendGrid(env('SENDGRID_API_KEY'));
                return new \Illuminate\Mail\Transport\SendgridTransport($client);
            });
        });
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['mail.manager']->extend('sendgrid', function ($config) {
            $client = new \SendGrid($config['key'] ?? env('SENDGRID_API_KEY'));
            return new \Illuminate\Mail\Transport\SendgridTransport($client);
        });
    }
}
