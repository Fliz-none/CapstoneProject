<?php

namespace App\Providers;

use App\Models\Detail;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Observers\DetailObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\UserObserver;

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
        User::observe(UserObserver::class);
        Controller::init();
        Schema::defaultStringLength(125);
        Detail::observe(DetailObserver::class);
    }
}
