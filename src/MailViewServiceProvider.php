<?php

namespace Julienbourdeau\MailView;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class MailViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(MailViewFinder::class, function () {
            return new MailViewFinder($this->app);
        });

        Gate::define('mail_view', function ($user) {
            return false;
        });

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mail-view');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('mail-view.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/mail-view'),
            ], 'views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-mail-view'),
            ], 'assets');*/
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'mail-view');
    }
}
