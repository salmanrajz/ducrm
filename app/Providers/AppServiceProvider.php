<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use AhmadMayahi\Vision\Vision;
use AhmadMayahi\Vision\Config;
use Illuminate\Pagination\Paginator;



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
        $this->app->singleton(Vision::class, function ($app) {
            $config = (new Config())
            ->setCredentials(config('vision.service_account_path'));

            return Vision::init($config);
        });
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();

    }
}
