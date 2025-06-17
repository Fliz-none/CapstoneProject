<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    /**
     * The authenticated user.
     *
     * @var \App\Models\User|null
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Controller::init();
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $this->user = Auth::user();
            } else {
                $this->user = null;
            }
            return $next($request);
        });
    }

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public static string $DATA_INVALID;
    public static string $NOT_EMPTY;
    public static string $ONE_LEAST;
    public static string $MIN;
    public static string $MAX;

    

    public static function init()
    {
        self::$DATA_INVALID = __('messages.data_invalid');
        self::$NOT_EMPTY = __('messages.not_empty');
        self::$ONE_LEAST = __('messages.one_least');
        self::$MIN = __('messages.min');
        self::$MAX = __('messages.max');
    }


    // public function options()
    // {
    //     return array(
    //         'permissions' => Permission::all(),
    //         'roles' => Role::all(),
    //         'users' => User::whereStatus(1)->get(),
    //         'cashiers' => User::permission(User::CREATE_TRANSACTION)->whereStatus(1)->get(),
    //         'dealers' => User::permission(User::CREATE_ORDER)->whereStatus(1)->get(),
    //         'products' => Product::whereStatus(1)->get(),
    //         'variables' => Variable::with(['_product'])->whereStatus(1)->get(),
    //         'orders' => Order::get(),
    //         'stocks' => Stock::with('_variable._product')->whereHas('import', function ($query) {
    //             $query->whereIn('warehouse_id', Auth::user()->warehouses->pluck('id'));
    //         })->where('quantity', '>', 0)->get(),
    //         'catalogues' => $this->getCatalogueChildren(Catalogue::whereStatus(1)->with('children')->get()),
    //         'attributes' => Attribute::orderBy('key', 'ASC')->get(),
    //         'logs' => Log::all(),
    //         'warehouses' => Warehouse::whereStatus(1)->whereIn('id', Auth::user()->warehouses->pluck('id'))->get(),
    //         'suppliers' => Supplier::whereStatus(1)->get(),
    //         'settings' => Setting::pluck('value', 'key'),
    //         'locals' => Local::pluck('city', 'district'),
    //         'branches' => Branch::all(),
    //     );
    // }

    public static function getCatalogueChildren($catalogues)
    {
        foreach ($catalogues as $key => $catalogue) {
            if ($catalogue->children->where('status', 1)->isNotEmpty()) {
                $catalogue->children = self::getCatalogueChildren($catalogue->children->where('status', 1));
            }
        }
        return $catalogues;
    }

    static function resetAutoIncrement($tables)
    {
        foreach ($tables as $key => $table) {
            DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
        }
    }

    /**
     * Lấy danh sách ID của các danh mục con (bao gồm các đời cháu).
     */
    static function getDescendantIds($id)
    {
        $children = Catalogue::where('parent_id', $id)->pluck('id');
        $descendantIds = $children->toArray();
        foreach ($children as $childId) {
            $descendantIds = array_merge($descendantIds, self::getDescendantIds($childId));
        }
        return array_unique($descendantIds);
    }
}
