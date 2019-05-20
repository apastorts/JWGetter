<?php

namespace Apastorts\JWGetter\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/database.php', 'database'
        );

        $this->commands([
            Apastorts\JWGetter\Commands\GetMidweekMeeting::class
        ]);
    }
}
