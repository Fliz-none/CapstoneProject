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
    const NAME = 'Order detail';

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
                    $detail = Detail::with('_order')->find($request->key);
                    if (!$detail) {
                        return response()->json(['errors' => ['message' => ['Not found!']]], 422);
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
    }

    public function remove(Request $request)
    {
        $names = [];
        foreach ($request->choices as $key => $id) {
            $obj = Detail::find($id);
            if ($obj) {
                DB::beginTransaction();
                try {
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
                    log_exception($e);
                    Controller::resetAutoIncrement(['imports', 'import_details', 'stocks', 'exports', 'export_details']);
                    return response()->json(['errors' => ['error' => ['An error occurred: ' . $e->getMessage()]]], 422);
                }
            }
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Deleted ' . self::NAME . ' ' . implode(', ', $names),
        ], 200);
    }
}
