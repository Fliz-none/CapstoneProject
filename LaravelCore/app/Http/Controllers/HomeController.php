<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $pageName = 'Home';
        $settings = Setting::pluck('value', 'key');
        $products = Product::where('status', '>', 0)
            ->orderBy('sort', 'ASC')
            ->paginate(12);
        $categories = Category::where('status', 1)
            ->with(['posts' => function ($query) {
                $query->where('status', '>', 0)
                    ->orderBy('created_at', 'DESC');
            }])
            ->orderBy('sort', 'ASC')->get();

        return view('web.home', compact('pageName', 'settings', 'products', 'categories'));
    }
    public function contact()
    {
        $pageName = 'Contact';
        $settings = Setting::pluck('value', 'key');
        return view('web.contact', compact('pageName', 'settings'));
    }
}
