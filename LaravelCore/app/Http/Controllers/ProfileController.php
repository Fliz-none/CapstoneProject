<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware(['verified','auth']);
    }
    
    public function profile()
    {
        $pageName = 'Account ' . Auth::user()->name;
        $settings = cache()->get('settings');
        return view('web.profile', compact('pageName', 'settings'));
    }
}
