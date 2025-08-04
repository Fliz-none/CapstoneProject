<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            // Locale đã được set xong ở đây
            Controller::init();
            return $next($request);
        });
    }
    public function changeLanguage(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:vn,en',
        ]);

        session(['locale' => $request->locale]);

        return response()->json([
            'status' => 'success',
            'message' => __('messages.language_changed'),
        ]);
    }
}
