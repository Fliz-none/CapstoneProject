<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
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

        if ($request->name) {
            $result = Image::where('name', $request->name)->first();
            if ($result) {
                return response()->json($result, 200);
            } else {
                abort(404);
            }
        } else {
            $result = Image::with('author')
                ->whereHas('company', function ($query) use ($request) {
                    $query->where('domain', 'like', $request->domain . '%');
                })->get();
        }
        return response()->json($result, 200);
    }
}
