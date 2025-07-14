<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Detail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $pageName = 'Checkout';
        $settings = cache()->get('settings');
        return view('web.checkout', compact('pageName', 'settings'));
    }

    public function cod(Request $request)
    {
        $pageName = 'Checkout';
        $settings = cache()->get('settings');
        return view('web.checkout-cod', compact('pageName', 'settings'));
    }

    public function vnpay(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('checkout');
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
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function vnpay_return(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;
        DB::beginTransaction();
        try {
            if ($request->vnp_ResponseCode == '00') {
                $order = Order::create([
                    'branch_id' => session()->get('sale_branch') ?? Branch::first()->id,
                    'customer_id' => $user->id,
                    'method' => 2, // Online
                    'total' => $cart->total,
                    'discount' => $cart->discount,
                    'status' => 2, // 2: Đã thanh toán và trong hàng đợi
                    'note' => $cart->note,
                ]);

                foreach ($cart->items as $item) {
                    // Detail::create([
                    //     'order_id' => $order->id,
                    //     'stock_id' => $item->stock_id,
                    //     'unit_id' => 1,
                    //     'quantity'=>23,
                    //     'price' ,
                    //     'discount',
                    //     'note',
                    // ]);
                }

                $cart->items()->delete();
                return redirect()->route('checkout.thankyou');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            log_exception($e);
            return redirect()->route('checkout')->with('response', [
                'status' => 'error',
                'msg' => 'Đã thanh toán thành công! Nhưng quá trính xử lý vẫn đang tiếp tục.',
            ]);
        }
    }

    public function thankyou(Request $request)
    {
        $pageName = 'Thank You';
        $settings = cache()->get('settings');
        return view('web.thankyou', compact('pageName', 'settings'));
    }
}
