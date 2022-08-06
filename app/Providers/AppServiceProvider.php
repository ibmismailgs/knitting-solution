<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Settings\Entities\CompanySettings;
use DB;
use Illuminate\Support\Facades\View;

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
        $settings=CompanySettings::first();
        View::share('settings',$settings);
    }
}
