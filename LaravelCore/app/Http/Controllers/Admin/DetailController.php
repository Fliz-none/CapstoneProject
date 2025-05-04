<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use App\Models\ExportDetail;
use App\Models\Stock;
use App\Models\User;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class DetailController extends Controller
{
    const NAME = 'chi tiết đơn hàng';

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin', 'auth']);
    }
    public function index(Request $request)
    {
        if (isset($request->key)) {
            switch ($request->key) {
                default:
                    $detail = Detail::with('info._pet._customer', 'info._doctor', '_service', '_order')->find($request->key);
                    if(!$detail) {
                        return response()->json(['errors' => ['message' => ['Không tìm thấy chi tiết đơn hàng']]], 422);
                    }
                    switch ($request->action) {
                        case 'print':
                            $result = view('admin.templates.prints.' . ($request->template != 'undefined' ? $request->template : 'commitment_a5'), ['detail' => $detail])->render();
                            break;
                        
                        default:
                            $result = $detail;
                            break;
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            $details = Detail::with(['order', 'stock.import_detail.variable'])->when($request->stock_id, function ($query) use ($request) {
                $query->where('stock_id', $request->stock_id);
            });
            return DataTables::of($details)
                ->addColumn('order_id', function ($obj) {
                    return '<a class="cursor-pointer btn-preview preview-order text-primary fw-bold" data-id="' . $obj->order_id . '" data-url="' . route('admin.order') . '">' . $obj->order->code . '</a>
                                    <br/><small>' . optional($obj->created_at)->format('d/m/Y H:i') . '</small>';
                })
                ->filterColumn('order_id', function ($query, $keyword) {
                    $query->whereHas('order', function ($query) use ($keyword) {
                        $query->whereRaw("CONCAT('DH', LPAD(id, 5, '0')) LIKE ?", ["%{$keyword}%"])
                            ->orwhereRaw("CONCAT('DH', id) LIKE ?", ["%{$keyword}%"]);
                    })
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                })
                ->orderColumn('order_id', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('product', function ($obj) {
                    return '<span class="fw-bold">' . $obj->stock->import_detail->variable->fullName . '</span>';
                })
                ->editColumn('quantity', function ($obj) {
                    return $obj->quantity . ' ' . $obj->unit->term . ' × ' . number_format($obj->price) . 'đ';
                })
                ->filterColumn('quantity', function ($query, $keyword) {
                    $query->where('quantity', 'like', "%" . $keyword . "%")
                        ->orWhere('price', 'like', "%" . $keyword . "%");
                })
                ->orderColumn('quantity', function ($query, $order) {
                    $query->orderBy('quantity', $order);
                })
                ->addColumn('amount', function ($obj) {
                    return number_format($obj->quantity * $obj->price) . 'đ';
                })->filterColumn('amount', function ($query, $keyword) {
                    $query->whereRaw('(quantity * price) LIKE ?', ["%$keyword%"]);
                })
                ->orderColumn('amount', function ($query, $order) {
                    $query->orderByRaw('(quantity * price) ' . $order);
                })
                ->rawColumns(['order_id', 'product', 'quantity', 'amount'])
                ->make(true);
        }
        if (isset($request->key)) {
            $detail = Detail::with(['_service'])->find($request->key);
            $ticket = $detail->_service->ticket;
            $indication = $detail->$ticket->load('info._doctor', 'detail._service');
            if ($indication) {
                switch ($request->action) {
                    case 'print':
                        return view('admin.templates.prints.indication_a5', ['indication' => $detail->$ticket]);
                    case "export":
                        if ($detail->_service->consumables) {
                            $consumables = json_decode($detail->_service->consumables);
                            foreach ($consumables as $key => $consumable) {
                                $quantity = $consumable->quantity * $consumable->unit_rate;
                                $variable = Variable::find($consumable->variable_id);
                                $stock_ids = $variable->getStocksToExport($quantity);
                                if ($stock_ids) {
                                    $stocks = Stock::with('import_detail._variable._product')->whereIn('id', $stock_ids)->get();
                                    foreach ($stocks as $e => $stock) {
                                        $stock->stockConvertQuantity = $stock->import_detail->_variable->convertUnit($stock->quantity);
                                        $stock->productName = $stock->productName();
                                        $stock->unit = $stock->import_detail->_variable->_units->where('rate', 1)->first();
                                    }
                                    $consumable->stocks = $stocks;
                                } else {
                                    return null;
                                }
                            }
                            $indication->detail->_service->consumables = json_encode($consumables);
                        }
                        $result = $indication;
                        break;
                    default:
                        $result = $indication;
                        break;
                }
                return response()->json($result, 200);
            } else {
                abort(404);
            }
        }
    }

    public function remove(Request $request)
    {
        $names = [];
        foreach ($request->choices as $key => $id) {
            $obj = Detail::find($id);
            if ($obj) {
                DB::beginTransaction();
                try {
                    if ($obj->service_id) {
                        $ticket = $obj->_service->ticket;
                        if ($ticket == null) {
                            $obj->delete();
                        } else if ($ticket != 'info' && $ticket != 'prescription') {
                            if ($obj->$ticket && !$obj->$ticket->status) {
                                $obj->$ticket->delete();
                            } else {
                                return response()->json(['errors' => ['message' => ['Không thể xóa dịch vụ đã thực hiện. Hãy thử xóa phiếu ' . $obj->_service->name]]], 422);
                            }
                        } else {
                            if (optional($obj->$ticket)->export_id) {
                                return response()->json(['errors' => ['message' => ['Không thể xóa đơn hàng đã xuất toa thuốc']]], 422);
                            }
                            optional($obj->$ticket)->delete();
                        }
                    }
                    if ($obj->stock_id) {
                        array_push($names, $obj->quantity . ' ' . $obj->_unit->term . ' ' . $obj->_stock->import_detail->_variable->_product->name . ' - ' . $obj->_stock->import_detail->_variable->name);
                        $obj->_stock->increment('quantity', $obj->quantity * $obj->_unit->rate);
                        $obj->export_detail->update(['quantity' => 0]);
                        $obj->update(['quantity' => 0]);
                        $obj->export_detail->delete();
                    }
                    $obj->delete();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error(
                        'Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                            'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                            'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                            'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                            'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
                    Controller::resetAutoIncrement(['imports', 'import_details', 'stocks', 'exports', 'export_details', 'infos', 'indications', 'quicktests', 'microscopes', 'bloodcells', 'biochemicals', 'surgeries', 'ultrasounds', 'xrays', 'prescriptions', 'prescription_details', 'accommodations']);
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
                }
            }
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Đã xóa chi tiết đơn hàng ' . implode(', ', $names),
        ], 200);
    }
}
