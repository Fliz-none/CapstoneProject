<?php

namespace App\Http\Controllers;

use App\Exceptions\OutOfStockException;
use App\Models\CartItem;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use StockChecker;

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
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required|integer|min:1',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        DB::beginTransaction();
        try {
            /** @var \App\Models\User|null */
            $user = Auth::user();
            $unitId = $request->unit_id;
            $requestedQuantity = $request->quantity;
            $userLat = $request->lat;
            $userLng = $request->lng;

            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

            // Lấy các item hiện tại trong cart của unit này
            $existingItems = $cart->items()->where('unit_id', $unitId)->get();
            $addedQuantity = $existingItems->sum('quantity');
            $totalNeeded = $requestedQuantity + $addedQuantity;

            // Gọi hàm phân bổ stock mới cho tổng quantity
            $allocator = new StockChecker();
            $allocations = $allocator->allocateStockForUnit($unitId, $totalNeeded, $userLat, $userLng);
            // Xoá các item cũ
            $cart->items()->where('unit_id', $unitId)->delete();
            // Tạo lại theo phân bổ mới
            foreach ($allocations as $allocation) {
                $stock = Stock::find($allocation['stock_id']);
                $item = CartItem::create([
                    'unit_id' => $unitId,
                    'quantity' => $allocation['quantity'],
                    'stock_id' => $stock->id,
                    'cart_id' => $cart->id,
                    'price' => $stock->import_detail->unit->price,
                    'allocated_to_warehouse_id' => $allocation['allocated_to_warehouse_id'] ?? null,
                ]);
            }
            
            DB::commit();
            return response()->json([
                'status' => 'success',
                'msg' => 'Đã thêm vào giỏ hàng!',
                'cart' => $cart->load('items.unit.variable.product'), // load lại các quan hệ nếu cần
            ], 200);
        } catch (OutOfStockException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Sản phẩm hiện đang hết hàng hoặc đã thêm tối đa vào giỏ',
                'cart' => $cart->load('items.unit.variable.product'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            log_exception($e);
            return response()->json([
                'status' => 'error',
                'msg' => 'Đã xảy ra lỗi! Vui lòng tải lại trang!',
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
            $cart->items()->where('unit_id', $request->unit_id)->delete();
            return response()->json([
                'status' => 'success',
                'msg' => 'Đã xóa khỏi giỏ hàng!',
                'cart' => $cart->load('items.unit.variable.product'), // load lại các quan hệ nếu cần
            ], 200);
        } catch (\Exception $e) {
            log_exception($e);
            return response()->json([
                'status' => 'error',
                'msg' => 'Đã xảy ra lỗi! Vui lòng tải lại trang!',
            ], 500);
        }
    }
}
