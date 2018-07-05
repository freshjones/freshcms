<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Variables;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //$settings = Variables::pluck('value', 'name')->all();
        //config()->set('settings', $settings);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
