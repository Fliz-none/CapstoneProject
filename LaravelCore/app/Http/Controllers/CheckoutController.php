<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Detail;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        return $this->processOrder($user, $cart,  1,  'Paid via Cash on Delivery');
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

        return $this->processOrder($user, $cart,  2, 'Paid via VNPay');
    }

    private function processOrder($user, $cart, $method = 2, $note = null)
    {
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('checkout')->with('response', [
                'status' => 'error',
                'msg' => 'Cart is empty!',
            ]);
        }

        DB::beginTransaction();
        try {
            $stocks = [];
            foreach ($cart->items as $item) {
                $stock = StockChecker::checkUnitStock($item);
                if (!$stock) {
                    DB::rollBack();
                    return redirect()->route('checkout')->with('response', [
                        'status' => 'error',
                        'msg' => 'Product "' . $item->unit->variable->fullName . '" is out of stock!',
                    ]);
                }
                $stocks[$item->id] = $stock;
            }

            $order = Order::create([
                'branch_id' => session()->get('sale_branch') ?? Branch::first()->id,
                'customer_id' => $user->id,
                'method' => $method,
                'total' => $cart->total,
                'discount' => $cart->discount ?? 0,
                'status' => 2,
                'note' => $cart->note,
            ]);

            foreach ($cart->items as $item) {
                $stock = $stocks[$item->id];

                Detail::create([
                    'order_id' => $order->id,
                    'stock_id' => $stock->id,
                    'unit_id' => $item->unit_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                $stock->decrement('quantity', $item->quantity);
            }

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

            $order_code = $order->code;
            $pageName = 'Thank You';
            return view('web.thankyou', compact('order_code', 'pageName'));
        } catch (\Exception $e) {
            DB::rollBack();
            log_exception($e);
            return redirect()->route('checkout')->with('response', [
                'status' => 'error',
                'msg' => 'Payment was successful, but the order is still being processed. Please contact support if you do not receive confirmation within a few minutes.',
            ]);
        }
    }
}
