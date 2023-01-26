<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

use App\Models\Setting;


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
        Schema::defaultStringLength(1000);
        Paginator::useBootstrap();

        $setting = Setting::select('mobile', 'whatsapp', 'email', 'facebook', 'twitter', 'instagram', 'youtube', 'linkedin', 'dark_logo', 'light_logo', 'favicon', 'address')->first();
        View::share('setting', $setting);
    }
}
