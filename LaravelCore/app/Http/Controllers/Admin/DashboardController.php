<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use App\Models\ExportDetail;
use App\Models\ImportDetail;
use App\Models\Order;
use App\Models\Pet;
use App\Models\Product;
use App\Models\Service;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    const NAME = 'bảng tin';

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin', 'auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pageName = 'Bảng tin';
        return view('admin.dashboard', compact('pageName'));
    }

    public function analytics(Request $request)
    {
        $result = [];
        $range = json_decode($request->range);
        $orders = Order::where('company_id', Auth::user()->company_id)->whereBetween('orders.created_at', $range)->get();
        // $details = Detail::whereHas('orders', function ($query) {
        //     $query->where('orders.company_id', $this->user->company_id);
        // })
        // ->whereBetween('created_at', $range);

        if ($request->has('key')) {
            // Tính khoảng cách bằng ngày
            $daysDifference = Carbon::parse($range[0])->diffInDays(Carbon::parse($range[1])) + 1;
            // Tính ngày trước đó
            $previousStartDate = Carbon::parse($range[0])->subDay($daysDifference)->format('Y-m-d') . ' 00:00:00';
            $previousEndDate = Carbon::parse($range[1])->subDay($daysDifference)->format('Y-m-d') . ' 23:59:59';

            // Lấy dữ liệu đơn hàng của ngày trước đó
            $previousOrders = Order::where('company_id', Auth::user()->company_id)
                ->whereBetween('orders.created_at', [$previousStartDate, $previousEndDate])
                ->get();

            // Gộp dữ liệu từ các đơn hàng hiện tại và trước đó
            $result['listOrders'] = [
                'previous' => $previousOrders->isNotEmpty() ? $this->groupAndSummarizeOrders($previousOrders) : [],
                'current' => $orders->isNotEmpty() ? $this->groupAndSummarizeOrders($orders) : [],
            ];

            return response()->json($result);
        }
        // Trả lại dữ liệu của Order theo khoảng ngày 

        //Doanh thu
        $transactions = Transaction::where('company_id', Auth::user()->company_id)->whereBetween('created_at', $range)->get();
        $result['allRevenue'] = $transactions->sum('amount');
        $result['cashRevenue'] = Order::where('company_id', Auth::user()->company_id)->whereBetween('created_at', $range)->whereIn('id', $transactions->pluck('order_id')->unique())->get()->sum('paid');
        $result['debtRevenue'] = $result['allRevenue'] - $result['cashRevenue'];

        // Tính doanh thu của phần sản phẩm
        $result['productSales'] = Detail::whereHas('order', function ($query) use ($range) {
            $query->where('company_id', Auth::user()->company_id)->whereBetween('created_at', $range);
        })->whereNotNull('stock_id') // Chỉ lấy những chi tiết có liên kết với sản phẩm
            ->sum(DB::raw(
                'quantity *
            CASE
                WHEN discount > 0 AND discount <= 100
                    THEN price * (1 - discount / 100)
                ELSE price - discount
            END'
            ));

        // Tính doanh thu của phần dịch vụ
        $result['serviceSales'] = Detail::whereHas('order', function ($query) use ($range) {
            $query->where('company_id', Auth::user()->company_id)->whereBetween('created_at', $range);
        })->whereNotNull('service_id') // Chỉ lấy những chi tiết có liên kết với dịch vụ
            ->sum(DB::raw(
                'quantity *
            CASE
                WHEN discount > 0 AND discount <= 100
                    THEN price * (1 - discount / 100)
                ELSE price - discount
            END'
            ));

        //Doanh số
        $result['allSales'] = $orders->sum('total');
        $result['cashSales'] = $orders->sum('paid');
        $result['debtSales'] = $result['allSales'] - $result['cashSales'];

        // Tính tổng giá vốn của sản phẩm từ bảng stocks
        $result['productCost'] = Detail::whereHas('order', function ($query) use ($range) {
            $query->where('company_id', Auth::user()->company_id)->whereBetween('created_at', $range);
        })
            ->whereNotNull('stock_id')
            ->join('stocks', 'details.stock_id', '=', 'stocks.id')
            ->join('import_details', 'stocks.import_detail_id', '=', 'import_details.id')
            ->join('units', 'units.id', '=', 'import_details.unit_id')
            ->sum(DB::raw('details.quantity * (import_details.price / units.rate)'));

        //Giá vốn dịch vụ từ vật tư tiêu hao
        $result['serviceCost'] = ExportDetail::with('export') // Eager load quan hệ với bảng Export
            ->join('stocks', 'export_details.stock_id', '=', 'stocks.id') // Kết nối với bảng stocks
            ->join('import_details', 'stocks.import_detail_id', '=', 'import_details.id') // Kết nối với bảng import_details
            ->whereNull('export_details.detail_id') // Lọc các chi tiết có detail_id là NULL
            ->whereHas('export', function ($query) { // Kiểm tra điều kiện trên bảng Export
                $query->whereNotNull('order_id')->where('company_id', Auth::user()->company_id);
            })
            ->whereBetween('export_details.created_at', $range) // Lọc theo thời gian tạo trong bảng ExportDetail
            ->sum(DB::raw('export_details.quantity * (import_details.price / export_details.unit_id)')); // Tính giá vốn

        //Lợi nhuận
        $result['allProfits'] = $result['allRevenue'] - $result['productCost'] - $result['serviceCost'];
        $result['totalOrderDiscount'] = $orders->sum(function ($order) {
            if ($order->discount > 0 && $order->discount <= 100) {
                return ($order->discount / 100) * $order->total;
            } else {
                return $order->discount;
            }
        });

        $result['productProfits'] = $result['allRevenue'] - $result['serviceSales'] - $result['productCost'];
        $result['serviceProfits'] = $result['allRevenue'] - $result['productSales'] - $result['serviceCost'];

        //Đơn hàng
        $result['allOrders'] = $orders->count();
        $result['completeOrders'] = $orders->where('status', 2)->count();
        $result['paidOrders'] = $orders->filter(function ($order) {
            return $order->total <= $order->paid;
        })->count();
        $result['cancelOrders'] = $orders->where('status', 0)->count();

        //Khách hàng
        $customers = User::where('company_id', Auth::user()->company_id)->whereHas('orders', function ($query) use ($range) {
            $query->whereBetween('orders.created_at', $range);
        })->get();
        $result['allCustomers'] = $customers->count();
        $result['oldCustomers'] = $customers->where('created_at', '<', $range[0])->count();
        $result['newCustomers'] = $result['allCustomers'] - $result['oldCustomers'];

        //Thú cưng
        $pets = Pet::where('company_id', Auth::user()->company_id)->whereHas('infos', function ($query) use ($range) {
            $query->whereBetween('infos.created_at', $range);
        })->get();
        $result['allPets'] = $pets->count();
        $result['oldPets'] = $pets->where('created_at', '<', $range[0])->count();
        $result['newPets'] = $result['allPets'] - $result['oldPets'];

        //Sản phẩm
        $result['allProducts'] = Product::where('company_id', Auth::user()->company_id)->where('status', '>', 0)->count();
        $result['allVariables'] = Variable::whereHas('_product', function ($query) {
            $query->where('company_id', Auth::user()->company_id);
        })->where('status', '>', 0)->count();
        $result['importProducts'] = Product::where('company_id', Auth::user()->company_id)->whereHas('variables.import_details.stock', function ($query) use ($range) {
            $query->whereBetween('created_at', $range);
        })->count();
        $result['exportProducts'] = Product::where('company_id', Auth::user()->company_id)->whereHas('variables.import_details.stock.export_details', function ($query) use ($range) {
            $query->whereBetween('created_at', $range);
        })->count();

        //Nhập hàng
        $result['allStocks'] = ImportDetail::whereHas('import', function ($query) use ($range) {
            $query->where('company_id', Auth::user()->company_id)->whereNull('export_id')
                ->whereBetween('created_at', $range);
        })->count();
        $result['saleStocks'] = Stock::where('company_id', Auth::user()->company_id)->whereBetween('created_at', $range)
            ->whereHas('export_details')
            ->count();
        $result['costStocks'] = ImportDetail::whereHas('import', function ($query) use ($range) {
            $query->where('company_id', Auth::user()->company_id)->whereBetween('created_at', $range);
        })->sum('price');
        $result['revenueStocks'] = Detail::whereHas('stock.import_detail._import', function ($query) use ($range) {
            $query->where('company_id', Auth::user()->company_id)->whereBetween('created_at', $range); // Nhập trong khoảng thời gian đã cho
        })
            ->sum(DB::raw(
                'quantity *
            CASE
                WHEN discount > 0 AND discount <= 100
                    THEN price * (1 - discount / 100)
                ELSE price - discount
            END'
            ));

        //Danh sách đơn hàng theo thời gian
        $result['listOrders'] = [
            'current' => $orders->isNotEmpty() ? $this->groupAndSummarizeOrders($orders) : [],
            'previous' => [],
        ];
        return response()->json($result, 200);
    }

    static function getUser($type, $range)
    {
        $result = []; // Khởi tạo mảng result

        switch ($type) {
            case 'revenue':
                $transactions = Transaction::with('_customer')
                    ->whereHas('_customer', function ($query) {
                        $query->where('company_id', Auth::user()->company_id); // Thêm điều kiện để lấy giao dịch thuộc công ty hiện tại
                    })
                    ->whereBetween('created_at', $range) // Lọc theo thời gian tạo
                    ->whereNotNull('customer_id')
                    ->select('customer_id', DB::raw('SUM(amount) as total'))
                    ->groupBy('customer_id')
                    ->having('total', '>', 0)
                    ->orderByDesc('total')
                    ->get(); // Lấy danh sách đơn hàng

                // Tạo mảng result từ dữ liệu đã truy vấn
                $result = $transactions->map(function ($transaction) {
                    return [
                        'name' => '<a class="cursor-pointer btn-update-user text-primary fw-bold" data-id="' . $transaction->_customer->id . '">' .  $transaction->_customer->name   . '</a>',
                        'total' =>  number_format($transaction->total),
                    ];
                });
                break;

            case 'quantity':
                $orders = Order::with('_customer')
                    ->whereBetween('created_at', $range) // Lọc theo thời gian tạo
                    ->whereHas('_customer', function ($query) {
                        $query->where('company_id', Auth::user()->company_id); // Thêm điều kiện để lấy giao dịch thuộc công ty hiện tại
                    })
                    ->whereNotNull('customer_id')
                    ->select('customer_id', DB::raw('COUNT(id) as total'))
                    ->groupBy('customer_id')
                    ->having('total', '>', 0)
                    ->orderByDesc('total')
                    ->get(); // Lấy danh sách đơn hàng

                // Tạo mảng result từ dữ liệu đã truy vấn
                $result = $orders->map(function ($order) {
                    return [
                        'name' => '<a class="cursor-pointer btn-update-user text-primary fw-bold" data-id="' . $order->_customer->id . '">' . $order->_customer->name  . '</a>',
                        'total' => $order->total, // Số lượng đơn hàng
                    ];
                });
                break;

            case 'debt':
                $users = User::with(['orders.details', 'orders.transactions'])
                    ->where('users.company_id', Auth::user()->company_id) // Lọc theo công ty
                    ->whereHas('orders', function ($query) use ($range) {
                        $query->whereBetween('created_at', $range); // Lọc theo thời gian tạo); // Lọc theo created_at của orders
                    })
                    ->get()
                    ->map(function ($user) {
                        // Tính tổng giá trị đơn hàng và tổng số tiền đã thanh toán
                        $totalOrderValue = $user->orders->sum('total');
                        $totalPaid = $user->orders->sum('paid');
                        // Tính công nợ
                        $debt = $totalOrderValue - $totalPaid;
                        // Chỉ lấy những người có công nợ (công nợ > 0)
                        if ($debt > 0) {
                            return [
                                'id' => $user->id,
                                'name' => $user->name, // Tên người dùng
                                'debt' => $debt, // Công nợ
                            ];
                        }

                        return null; // Trả về null nếu không có công nợ
                    })
                    ->filter() // Loại bỏ các giá trị null (không có công nợ)
                    ->sortByDesc('debt'); // Sắp xếp công nợ từ cao đến thấp
                // Trả về kết quả
                $result = $users->map(function ($user) {
                    return [
                        'name' => '<a class="cursor-pointer btn-update-user text-primary fw-bold" data-id="' . $user['id'] . '">' .$user['name']  . '</a>', // Tên người dùng
                        'total' => number_format($user['debt']), // Công nợ, định dạng số có 2 chữ số thập phân
                    ];
                });
                break;
            default:
                return response()->json([]); // Trả về mảng rỗng nếu không có type hợp lệ
        }
        // Trả về dữ liệu dưới dạng DataTables
        return $result;
    }

    static function getProduct($type, $range)
    {
        $result = [];
        switch ($type) {
            case 'revenue':
                $stocks = ExportDetail::with('_unit._variable._product', '_export')
                    ->whereHas('_export', function ($query) {
                        $query->where('company_id', Auth::user()->company_id);
                    })->whereBetween('created_at', $range)->get();

                $data = [];
                foreach ($stocks as $exportDetail) {
                    $productId = $exportDetail->_unit->_variable->_product->id; // ID sản phẩm
                    $productName = $exportDetail->_unit->_variable->_product->name; // Tên sản phẩm
                    $variantName = $exportDetail->_unit->_variable->name; // Tên biến thể
                    $unitPrice = $exportDetail->_unit->price; // Giá của unit
                    $quantity = $exportDetail->quantity; // Số lượng xuất
                    $value = $quantity * $unitPrice;
                    // Gộp theo tên sản phẩm - biến thể
                    $key = $productName . ' - ' . $variantName;
                    if (!isset($data[$key])) {
                        $data[$key] = [
                            'total' => 0,
                            'id' => $productId, // Lưu ID sản phẩm cho mục đích xử lý
                        ];
                    }
                    $data[$key]['total'] += $value;
                }

                // Trả kết quả
                foreach ($data as $key => $pro) {
                    if ($pro['total'] > 0) { // Điều kiện lọc
                        $result[] = [
                            'name' => '<a class="cursor-pointer btn-update-product text-primary fw-bold" data-id="' . $pro['id'] . '">' . $key . '</a>',
                            'total' => number_format($pro['total']),
                        ];
                    }
                }
                break;
            case 'quantity':
                $stocks = ExportDetail::with('_unit._variable._product')
                    ->whereHas('_export', function ($query) {
                        $query->where('company_id', Auth::user()->company_id);
                    })->whereBetween('created_at', $range)->get();
                $data = [];
                foreach ($stocks as $exportDetail) {
                    $productId = $exportDetail->_unit->_variable->_product->id; // ID sản phẩm
                    $productName = $exportDetail->_unit->_variable->_product->name; // Tên sản phẩm
                    $variantName = $exportDetail->_unit->_variable->name; // Tên biến thể
                    $quantity = $exportDetail->quantity; // Số lượng xuất

                    // Gộp theo tên sản phẩm - biến thể
                    $key = $productName . ' - ' . $variantName;
                    if (!isset($data[$key])) {
                        $data[$key] = [
                            'total' => 0,
                            'id' => $productId, // Lưu ID sản phẩm cho mục đích xử lý
                        ];
                    }
                    $data[$key]['total'] += $quantity;
                }
                arsort($data);

                // Chuẩn bị kết quả
                foreach ($data as $key => $pro) {
                    if ($pro['total'] > 0) { // Điều kiện lọc
                        $result[] = [
                            'name' => '<a class="cursor-pointer btn-update-product text-primary fw-bold" data-id="' . $pro['id'] . '">' . $key . '</a>',
                            'total' => number_format($pro['total']),
                        ];
                    }
                }
                break;
            default:
                return response()->json([]);
        }

        // Trả về dữ liệu dưới dạng DataTables
        return $result;
    }

    static function getService($type, $range)
    {
        $result = [];

        switch ($type) {
            case 'revenue':
                $details = Detail::with('_service')
                    ->whereBetween('created_at', $range)
                    ->whereNotNull('service_id')
                    ->whereHas('_service', function ($query) {
                        $query->where('company_id', Auth::user()->company_id);
                    })
                    ->get();

                $data = [];
                foreach ($details as $detail) {
                    $serviceId = $detail->_service->id;
                    $serviceName = $detail->_service->name;
                    $totalPrice = $detail->quantity * $detail->_service->price;

                    // Nếu dịch vụ chưa tồn tại trong $data, khởi tạo
                    if (!isset($data[$serviceId])) {
                        $data[$serviceId] = [
                            'name' => $serviceName,
                            'total' => 0,
                        ];
                    }

                    // Cộng dồn doanh thu cho dịch vụ
                    $data[$serviceId]['total'] += $totalPrice;
                }

                $result = [];
                foreach ($data as $serviceId => $serviceData) {
                    if ($serviceData['total'] > 0) { // Chỉ lấy các dịch vụ có doanh thu lớn hơn 0
                        $result[] = [
                            'name' => '<a class="cursor-pointer btn-update-service text-primary fw-bold" data-id="' . $serviceId . '">' . $serviceData['name'] . '</a>',
                            'total' => number_format($serviceData['total']), // Định dạng số doanh thu
                        ];
                    }
                }

                break;

            case 'quantity':
                $details = Detail::with('service')
                    ->whereBetween('created_at', $range)
                    ->whereNotNull('service_id')
                    ->whereHas('service', function ($query) {
                        $query->where('company_id', Auth::user()->company_id);
                    })
                    ->get();

                // Nhóm theo service_id và đếm số lần sử dụng
                $serviceCounts = $details->groupBy('service_id')->map(function ($items) {
                    return $items->count(); // Đếm số lần xuất hiện của mỗi service_id
                });

                // Lọc các dịch vụ có số lần sử dụng lớn hơn 0
                $filteredServiceCounts = $serviceCounts->filter(function ($count) {
                    return $count > 0;
                });

                // Lấy tên dịch vụ theo service_id và số lần sử dụng
                $serviceData = $filteredServiceCounts->map(function ($count, $serviceId) {
                    // Lấy tên dịch vụ một lần từ bảng services
                    $service = Service::find($serviceId);
                    return [
                        'name' => '<a class="cursor-pointer btn-update-service text-primary fw-bold" data-id="' . $service->id . '">' .  $service->name . '</a>', // Trả về tên dịch vụ nếu có
                        'total' => $count, // Số lần sử dụng (không cần format số vì sẽ làm ở front-end)
                    ];
                });

                // Sắp xếp mảng theo số lần sử dụng từ cao đến thấp
                $result  = $serviceData->sortByDesc('total')->values()->toArray();
                break;

            default:
                return response()->json([]);
        }

        // Trả về dữ liệu dưới dạng DataTables
        return $result;
    }

    // Hàm trả dữ liệu về 
    private function groupAndSummarizeOrders($orders)
    {
        return $orders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('Y-m-d');
        })->map(function ($dayOrders, $date) {
            return [
                'created_at' => $date,
                'count' => $dayOrders->count(),
                'total' => $dayOrders->sum('total'),
                'paid' => $dayOrders->sum('paid'),
            ];
        })->values();
    }

    public function statistics(Request $request)
    {
        $range = json_decode($request->range);
        switch ($request->model) {
            case 'user':
                $result = $this->getUser($request->type, $range);
                break;
            case 'product':
                $result = $this->getProduct($request->type, $range);
                break;
            case 'service':
                $result = $this->getService($request->type, $range);
                break;

            default:
                abort(404);
                break;
        }
        return DataTables::of($result)
        ->rawColumns(['name'])
        ->make(true);
    }
}
