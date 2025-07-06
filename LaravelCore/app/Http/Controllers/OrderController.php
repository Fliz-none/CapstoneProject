<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orders()
    {
        $pageName = 'Orders of ' . Auth::user()->name;
        $settings = cache()->get('settings');
        return view('web.orders', compact('pageName', 'options'));
    }
}
