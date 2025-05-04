<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        $pageName = 'Giỏ hàng';
        $settings = Setting::pluck('value', 'key');
        return view('web.cart', compact('pageName', 'settings'));
    }
}
