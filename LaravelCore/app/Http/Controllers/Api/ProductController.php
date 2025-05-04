<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra nếu không có domain hoặc Origin
        $origin = $request->header('Origin');

        if (!$request->domain || !$origin) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        // So sánh Origin và domain
        if ($origin != $request->domain) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        if ($request->slug) {
            $result = Product::with('catalogues', 'variables.units')
                ->where('status', 2)
                ->whereHas('company', function ($query) use ($request) {
                    $query->where('domain', 'like', '%' . $request->domain . '%');
                })
                ->where('slug', $request->slug)
                ->first();

            if ($result) {
                return response()->json($result, 200);
            } else {
                abort(404);
            }
        } else {
            $result = Product::with('catalogues', 'variables.units')
                ->where('status', 2)
                ->whereHas('company', function ($query) use ($request) {
                    $query->where('domain', 'like', $request->domain . '%');
                })->get();
        }

        return response()->json($result, 200);
    }

}
