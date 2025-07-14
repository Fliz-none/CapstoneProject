<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart()
    {
        $pageName = 'Cart';
        $settings = cache()->get('settings');
        return view('web.cart', compact('pageName', 'settings'));
    }

    public function add(Request $request)
    {
        // Validate
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required|integer|min:1',
        ]);
        try {
            /** @var \App\Models\User|null */
            $user = Auth::user();

            // Lấy hoặc tạo giỏ hàng cho user, tìm unit
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
            $unit = Unit::findOrFail($request->unit_id);

            // Kiểm tra nếu unit đã có trong cart -> cập nhật số lượng
            $existingItem = $cart->items()->where('unit_id', $request->unit_id)->first();
            if ($existingItem) {
                $existingItem->increment('quantity', $request->quantity);
            } else {
                $cart->items()->create([
                    'unit_id' => $request->unit_id,
                    'quantity' => $request->quantity,
                    'cart_id' => $cart->id,
                    'price' => $unit->price,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'msg' => 'Added to cart successfully!',
                'cart' => $cart->load('items.unit.variable.product'), // load lại các quan hệ nếu cần
            ], 200);
        } catch (\Exception $e) {
            log_exception($e);
            return response()->json([
                'status' => 'error',
                'msg' => 'Something went wrong! Please try again later',
            ], 500);
        }
    }

    public function remove(Request $request)
    {
        // Validate
        $request->validate([
            'unit_id' => 'required|exists:units,id',
        ]);

        try {
            /** @var \App\Models\User|null */
            $user = Auth::user();

            // Lấy hoặc tạo giỏ hàng cho user, tìm unit
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
            $unit = Unit::findOrFail($request->unit_id);

            $existingItem = $cart->items()->where('unit_id', $request->unit_id)->first();
            if ($existingItem) {
                $existingItem->delete();
            }

            return response()->json([
                'status' => 'success',
                'msg' => 'Removed from cart successfully!',
                'cart' => $cart->load('items.unit.variable.product'), // load lại các quan hệ nếu cần
            ], 200);
        } catch (\Exception $e) {
            log_exception($e);
            return response()->json([
                'status' => 'error',
                'msg' => 'Something went wrong! Please try again later',
            ], 500);
        }
    }
}
