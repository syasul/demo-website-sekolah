<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('school_settings')) {
                    $view->with('schoolSetting', \App\Models\SchoolSetting::getActive());
                }
            } catch (\Throwable $e) {
                // Ignore during early migrations
            }
        });
    }
}
