<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        $pageName = 'Cart';
        $settings = cache()->get('settings');
        return view('web.cart', compact('pageName', 'settings'));
    }
}
