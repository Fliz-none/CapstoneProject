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
            if (!Cache::has('roles_' . $user->company_id)) {
                $roles = Role::where('company_id', $user->company_id)->where('id', '!=', 1)->pluck('name', 'id');
                if ($user->hasRole('Super Admin')) {
                    $roles->put(1, "Super Admin");
                }
                Cache::put('roles_' . $user->company_id, $roles, now()->addHours(24));
            }
            if (!Cache::has('animals_' . $user->company_id)) {
                Cache::put('animals_' . $user->company_id, Animal::distinct()->pluck('specie'), now()->addHours(24));
            }
            if (!Cache::has('attributes_' . $user->company_id)) {
                Cache::put('attributes_' . $user->company_id, Attribute::select('id', 'key', 'value')->where('company_id', $user->company_id)->get(), now()->addHours(24));
            }
            if (!Cache::has('dealers_' . $user->company_id)) {
                Cache::put('dealers_' . $user->company_id, User::where('company_id', $user->company_id)->permission(User::CREATE_ORDER)->pluck('name', 'id'), now()->addHours(24));
            }
            if (!Cache::has('cashiers_' . $user->company_id)) {
                Cache::put('cashiers_' . $user->company_id, User::where('company_id', $user->company_id)->permission(User::CREATE_TRANSACTION)->pluck('name', 'id'), now()->addHours(24));
            }
            if (!Cache::has('warehouses_' . $user->company_id)) {
                Cache::put('warehouses_' . $user->company_id, Warehouse::where('company_id', $user->company_id)->where('status', '>', 0)->get(), now()->addHours(24));
            }
            if (!Cache::has('branches_' . $user->company_id)) {
                Cache::put('branches_' . $user->company_id, Branch::where('company_id', $user->company_id)->where('status', '>', 0)->get(), now()->addHours(24));
            }
            if (!Cache::has('categories_' . $user->company_id)) {
                Cache::put('categories_' . $user->company_id, Category::select('id', 'slug', 'name')->where('company_id', $user->company_id)->where('company_id', $user->company_id)->where('status', '>', 0)->orderBy('sort', 'ASC')->get(), now()->addHours(60));
            }
            if (!Cache::has('catalogues_' . $user->company_id)) {
                Cache::put('catalogues_' . $user->company_id, Controller::getCatalogueChildren(Catalogue::where('company_id', $user->company_id)->where('status', '>', 0)->with('children')->get()), now()->addHours(60));
            }
            if (!Cache::has('settings_' . $user->company_id)) {
                $settings = Setting::where('company_id', $user->company_id)->pluck('value', 'key');
                Cache::put('settings_' . $user->company_id, $settings, now()->addMinutes(60));
            }
            if (!Cache::has('services_' . $user->company_id)) {
                Cache::put('services_' . $user->company_id, Service::where('company_id', $user->company_id)
                    ->with('symptoms', '_major')
                    ->select('id', 'name', 'price', 'major_id', 'ticket', 'is_indicated', 'commission', 'unit')
                    ->where('status', '>', 0)->get(), now()->addHours(12));
            }
            if (!Cache::has('symptoms_' . $user->company_id)) {
                $symptoms = Symptom::where('id', '>', 4)
                    ->where('company_id', $user->company_id)
                    ->orderByRaw("CASE WHEN `group` = 'Khác' THEN 1 ELSE 0 END")
                    ->orderBy('group')
                    ->get();
                Cache::put('symptoms_' . $user->company_id, $symptoms, now()->addMinutes(15));
            }
            if (!Cache::has('diseases_' . $user->company_id)) {
                Cache::put('diseases_' . $user->company_id, Disease::with('symptoms', 'medicines', 'services')->where('company_id', $user->company_id)->get(), now()->addMinutes(15));
            }
            if (!Cache::has('medicines_' . $user->company_id)) {
                Cache::put('medicines_' . $user->company_id, Medicine::where('company_id', $user->company_id)->with('symptoms', 'dosages', '_variable.units')->get(), now()->addMinutes(15));
            }
            if (!Cache::has('version_' . $user->company_id)) {
                Cache::put('version_' . $user->company_id, Version::orderBy('id', 'DESC')->first(), now()->addHours(12));
            }
            if (!Cache::has('zalo_access_token_' . $user->company_id) && !Cache::has('zalo_refresh_token_' . $user->company_id)) {
                $settings = cache()->get('settings_' . $user->company_id);
                Cache::put('zalo_access_token_' . $user->company_id, $settings['zalo_access_token'], now()->addSeconds(3600));
                Cache::put('zalo_refresh_token_' . $user->company_id, $settings['zalo_refresh_token'], now()->addDays(30));
            }
            
        }
        return $next($request);
    }
}
