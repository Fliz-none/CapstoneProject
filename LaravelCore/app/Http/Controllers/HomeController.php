<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function home()
    {
        $pageName = 'Home';
        try {
            DB::select('select 1');
            $settings = cache()->get('settings');
            $products = Product::where('status', '>', 0)
                ->orderBy('sort', 'ASC')
                ->paginate(12);
            $categories = Category::where('status', 1)
                ->with(['posts' => function ($query) {
                    $query->where('status', '>', 0)
                        ->orderBy('created_at', 'DESC');
                }])
                ->orderBy('sort', 'ASC')
                ->get();

            return view('web.home', compact('pageName', 'settings', 'products', 'categories'));

        } catch (\Exception $e) {
            log_exception($e);
            abort(500);
        }
    }

    public function contact()
    {
        $pageName = 'Contact';

        try {
            DB::select('select 1');
            $settings = cache()->get('settings');
        } catch (\Exception $e) {
            log_exception($e);
            $settings = collect();
        }
        return view('web.contact', compact('pageName', 'settings'));
    }
}
