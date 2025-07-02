<?php

namespace App\Providers;

use App\Models\Detail;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Observers\DetailObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\UserObserver;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

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


        DB::listen(function (QueryExecuted $query) {
            if ($query->time > 1000) { // Thời gian tính bằng milliseconds
                Log::warning('Long query detected', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time_ms' => $query->time,
                ]);
            }
        });
    }
}
