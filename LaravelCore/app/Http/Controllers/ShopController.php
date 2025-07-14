<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Validate the request
        $request->validate([
            'search' => 'nullable|string|max:255',
            'catalogue_slug' => 'nullable|string|max:255',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'order' => [
                'nullable',
                'string',
                Rule::in(['created_at-asc', 'created_at-desc', 'name-asc', 'name-desc']), 
            ],
        ]);
        $pageName = 'Cửa hàng';

        $catalogues = Catalogue::where('status', 1)
            ->where('is_featured', 1)
            ->orderBy('sort')
            ->get();

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator|null
         */
        $query = Product::whereIn('status', [2, 3]);

        // Lọc theo từ khóa tìm kiếm
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        } else {
            // Lọc theo danh mục (nhiều checkbox)
            if ($request->filled('catalogue_slug')) {
                $slug = $request->input('catalogue_slug');

                $query->whereHas('catalogues', function ($q) use ($slug) {
                    $q->where('slug', $slug)
                        ->where('status', 1)
                        ->where('is_featured', 1);
                });
            } else {
                // Nếu không chọn danh mục nào vẫn lọc theo danh mục nổi bật
                $query->whereHas('catalogues', function ($q) {
                    $q->where('status', 1)->where('is_featured', 1);
                });
            }

            // Lọc theo giá
            if ($request->filled('price_min')) {
                $query->where('price', '>=', $request->price_min);
            }
            if ($request->filled('price_max')) {
                $query->where('price', '<=', $request->price_max);
            }
        }
        if ($request->filled('order') && $request->order !== 'default') {
            [$field, $direction] = explode('-', $request->order);
            $query->orderBy($field, $direction);
        } else {
            $query->orderBy('sort'); // Mặc định
        }

        $products = $query->paginate(12)->withQueryString();
        return view('web.shop', compact('catalogues', 'pageName', 'products'));
    }
}
