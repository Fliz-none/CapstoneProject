<?php

namespace App\Providers;

use App\Models\Detail;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Observers\DetailObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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

        View::composer([
            '*',
        ], function ($view) {
            // $auth = Auth::user();
            $view->with('config', [
                'app_name' => config('app.name'),
                'currency' => Setting::where('key', 'currency')->first()->value ?? 'VND',
                'company_name' => Setting::where('key', 'company_name')->first()->value ?? config('app.name'),
            ]);
        });
    }
}
