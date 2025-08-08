<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\StockController;
use App\Models\Branch;
use App\Models\Detail;
use App\Models\Export;
use App\Models\ExportDetail;
use App\Models\Import;
use App\Models\ImportDetail;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use StockChecker;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::user()->cart) return redirect()->route('home');
        $pageName = 'Checkout';
        $settings = cache()->get('settings');
        return view('web.checkout', compact('pageName', 'settings'));
    }

    public function cod(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;

        return $this->processOrder(1,  'Paid via Cash on Delivery');
    }

    public function vnpay(Request $request)
    {
        try {
            $user = Auth::user();
            $cart = $user->cart;
            if (!$cart || $cart->items->count() == 0) {
                return redirect()->route('checkout')->with('response', [
                    'status' => 'error',
                    'msg' => 'Cart is empty <i class="bi bi-cart-x"></i>',
                ]);
            }

            $vnp_Url = env('VNPAY_URL');
            $vnp_Returnurl = route('checkout.vnpay_return');
            $vnp_TmnCode = env('VNPAY_TMNCODE');
            $vnp_HashSecret = env('VNPAY_HASHSECRET');
            $vnp_TxnRef = Carbon::now()->timestamp . $user->code;
            $vnp_OrderInfo = 'Payment for order ' . $vnp_TxnRef;
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $cart->total * 100;
            $vnp_Locale = session()->get('locale') ?? 'vn';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            return redirect($vnp_Url);
        } catch (\Exception $e) {
            log_exception($e);
            return redirect()->back()->with('response', [
                'status' => 'error',
                'msg' => 'An error occurred, please reload the page and try again.',
            ]);
        }
    }

    public function vnpay_return(Request $request)
    {
        if ($request->vnp_TransactionStatus != '00') {
            return redirect()->route('checkout')->with('response', [
                'status' => 'error',
                'msg' => 'The transaction was canceled or declined!',
            ]);
        }

        $user = Auth::user();
        $cart = $user->cart;

        return $this->processOrder(2, 'Paid via VNPay');
    }

    private function processOrder($method = 2, $note = 'Online order!')
    {
        $user = Auth::user();
        $cart = $user->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('checkout')->with('response', [
                'status' => 'error',
                'msg' => 'Cart is empty!',
            ]);
        }

        DB::beginTransaction();
        try {
            // Chi nhánh quản lý đơn
            $branch_id = optional(
                $cart->items->firstWhere('allocated_to_warehouse_id', '!=', null)
            )->allocated_to_warehouse->branch_id ?? Branch::where('status', 1)->latest()->first()->id;

            $order = Order::create([
                'branch_id' => $branch_id,
                'customer_id' => $user->id,
                'method' => $method,
                'total' => $cart->total,
                'discount' => $cart->discount ?? 0,
                'status' => 2,
                'note' => $cart->note,
            ]);
            // Trung chuyển kho nếu có
            $this->exportForOrder($order, $branch_id);
            // Export cho đơn
            $export = Export::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'status' => 1,
                'note' => 'Export for ' . $order->code,
                'date' => date('Y-m-d'),
            ]);

            foreach ($cart->items as $item) {
                $stock = $item->stock;
                $detail = Detail::create([
                    'order_id' => $order->id,
                    'stock_id' => $stock->id,
                    'unit_id' => $item->unit_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
                $export_detail = ExportDetail::create([
                    'stock_id' => $stock->id,
                    'export_id' => $export->id,
                    'detail_id' => $detail->id,
                    'unit_id' => $item->unit_id,
                    'quantity' => $item->quantity,
                    'note' => 'Export for ' . $order->code
                ]);

                $variable = $stock->import_detail->_variable;
                if ($variable->isExhausted()) {
                    StockController::pushExhaustedNoti($stock, $variable);
                }
                $stock->decrement('quantity', $item->quantity);
                Log::info('$item :' . $item->unit->term . ' - ' . $item->quantity . ' Stock_id ' . $stock->id);
            }
            if ($method == 2)
                Transaction::create([
                    'order_id' => $order->id,
                    'customer_id' => $user->id,
                    'payment' => $method,
                    'amount' => $cart->total,
                    'note' => $note,
                    'date' => Carbon::now(),
                ]);

            $cart->items()->delete();
            DB::commit();

            $pageName = 'Thank You';
            return view('web.thankyou', compact('order', 'pageName'));
        } catch (\Exception $e) {
            DB::rollBack();
            log_exception($e);
            return redirect()->route('checkout')->with('response', [
                'status' => 'error',
                'msg' => 'An error occurred, Please contact support if you do not receive confirmation within a few minutes.',
            ]);
        }
    }

    private function exportForOrder($order, $branch_id = null)
    {
        DB::beginTransaction();
        try {
            $cart = Auth::user()->cart;
            foreach ($cart->items as $i => $item) {
                if ($item->allocated_to_warehouse_id) {
                    $export = Export::create([
                        'date' => date('Y-m-d'),
                        'to_warehouse_id' => $item->allocated_to_warehouse_id,
                        'order_id' => $order->id,
                        'note' => 'System: Allocate goods for ' . $order->code,
                        'status' => 1,
                    ]);

                    $import = Import::create([
                        'user_id' => $this->user->id,
                        'warehouse_id' => $item->allocated_to_warehouse_id,
                        'export_id' => $export->id,
                        'note' => 'System: Allocate goods for ' . $export->code,
                        'created_at' => $export->created_at,
                        'status' => 1,
                    ]);

                    $export_detail = ExportDetail::create([
                        'export_id' => $export->id,
                        'stock_id' => $item->stock_id,
                        'unit_id' => $item->unit_id,
                        'quantity' => $item->quantity,
                        'note' => 'System: Allocate goods for ' . $export->code
                    ]);

                    $import_detail = ImportDetail::create([
                        'import_id' => $import->id,
                        'export_detail_id' => $export_detail->id,
                        'variable_id' => $item->unit->variable_id,
                        'unit_id' => $item->unit_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ]);

                    $stock = Stock::create([
                        'import_detail_id' => $import_detail->id,
                        'quantity' => $item->quantity,
                        'lot' => $export_detail->_stock->lot,
                        'expired' => $export_detail->_stock->expired
                    ]);

                    $old_stock = $export_detail->_stock;
                    $old_stock->decrement('quantity', $item->quantity);
                    $item->update([
                        'stock_id' => $stock->id
                    ]);
                    Log::info('Giam o chuyen kho:  ' . $item->quantity . ' Stock id: ' . $old_stock->id);
                };
                // if ($variable->isExhausted()) {
                //     StockController::pushExhaustedNoti($stock, $variable);
                // }
                // Không thông báo hết hàng vì chuyển kho
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
