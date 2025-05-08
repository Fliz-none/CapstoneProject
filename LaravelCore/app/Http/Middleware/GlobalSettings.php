<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\Disease;
use App\Models\Medicine;
use App\Models\Service;
use App\Models\Symptom;
use Closure;
use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use App\Models\Version;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class GlobalSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * The authenticated user.
         *
         * @var \App\Models\User|null
         */
        $user = Auth::user();
        if (Auth::check()) {
            if (!Cache::has('roles')) {
                $roles = Role::where('id', '!=', 1)->pluck('name', 'id');
                if ($user->hasRole('Super Admin')) {
                    $roles->put(1, "Super Admin");
                }
                Cache::put('roles', $roles, now()->addHours(24));
            }
            if (!Cache::has('attributes')) {
                Cache::put('attributes', Attribute::select('id', 'key', 'value')->get(), now()->addHours(24));
            }
            if (!Cache::has('dealers')) {
                Cache::put('dealers', User::permission(User::CREATE_ORDER)->pluck('name', 'id'), now()->addHours(24));
            }
            if (!Cache::has('cashiers')) {
                Cache::put('cashiers', User::permission(User::CREATE_TRANSACTION)->pluck('name', 'id'), now()->addHours(24));
            }
            if (!Cache::has('warehouses')) {
                Cache::put('warehouses', Warehouse::where('status', '>', 0)->get(), now()->addHours(24));
            }
            if (!Cache::has('branches')) {
                Cache::put('branches', Branch::where('status', '>', 0)->get(), now()->addHours(24));
            }
            if (!Cache::has('categories')) {
                Cache::put('categories', Category::select('id', 'slug', 'name')->where('status', '>', 0)->orderBy('sort', 'ASC')->get(), now()->addHours(60));
            }
            if (!Cache::has('catalogues')) {
                Cache::put('catalogues', Controller::getCatalogueChildren(Catalogue::where('status', '>', 0)->with('children')->get()), now()->addHours(60));
            }
            if (!Cache::has('settings')) {
                $settings = Setting::pluck('value', 'key');
                Cache::put('settings', $settings, now()->addMinutes(60));
            }
            if (!Cache::has('version')) {
                Cache::put('version', Version::orderBy('id', 'DESC')->first(), now()->addHours(12));
            }
            // if (!Cache::has('zalo_access_token') && !Cache::has('zalo_refresh_token')) {
            //     $settings = cache()->get('settings');
            //     Cache::put('zalo_access_token', $settings['zalo_access_token'], now()->addSeconds(3600));
            //     Cache::put('zalo_refresh_token', $settings['zalo_refresh_token'], now()->addDays(30));
            // }
            
        }
        return $next($request);
    }
}
