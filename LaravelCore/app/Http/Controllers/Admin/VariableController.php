<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class VariableController extends Controller
{
    const NAME = 'biến thể',
        MESSAGES = [
            'name.required' => 'Tên biến thể' . Controller::NOT_EMPTY,
            'name.string' => 'Tên biến thể' . Controller::DATA_INVALID,
            'name.max' => 'Tên biến thể' . Controller::MAX,
            'status.numeric' => 'Trạng thái' . Controller::DATA_INVALID,
            'description.string' => 'Mô tả' . Controller::DATA_INVALID,

            'stock_limit.required' => Controller::NOT_EMPTY,
            'stock_limit.numeric' => Controller::DATA_INVALID,
            'variable_id.required' => 'Cần tạo biến thể trước',
            'variable_id.numeric' => 'Mã biến thể' . Controller::DATA_INVALID,

            'unit_term.required' => 'Tên đơn vị: ' . Controller::NOT_EMPTY,
            'unit_term.array' => 'Tên đơn vị: ' . Controller::DATA_INVALID,
            'unit_term.*.required' => 'Tên đơn vị: ' . Controller::NOT_EMPTY,
            'unit_term.*.string' => 'Tên đơn vị: ' . Controller::DATA_INVALID,

            'unit_barcode.required' => 'Mã vạch: ' . Controller::NOT_EMPTY,
            'unit_barcode.array' => 'Mã vạch: ' . Controller::DATA_INVALID,
            'unit_barcode.*.required' => 'Mã vạch: ' . Controller::NOT_EMPTY,
            'unit_barcode.*.string' => 'Mã vạch: ' . Controller::DATA_INVALID,

            'unit_price.required' => 'Giá bán: ' . Controller::NOT_EMPTY,
            'unit_price.array' => 'Giá bán: ' . Controller::DATA_INVALID,
            'unit_price.*.required' => 'Giá bán: ' . Controller::NOT_EMPTY,
            'unit_price.*.numeric' => 'Giá bán: ' . Controller::DATA_INVALID,

            'unit_rate.required' => 'Tỷ lệ chuyển đổi: ' . Controller::NOT_EMPTY,
            'unit_rate.array' => 'Tỷ lệ chuyển đổi: ' . Controller::DATA_INVALID,
            'unit_rate.*.required' => 'Tỷ lệ chuyển đổi: ' . Controller::NOT_EMPTY,
            'unit_rate.*.numeric' => 'Tỷ lệ chuyển đổi: ' . Controller::DATA_INVALID,
        ];

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
            $objs = Variable::whereNull('deleted_at')->whereStatus(1);
            switch ($request->key) {
                case 'list':
                    $result = $objs->get();
                    break;
                case 'select2':
                    $result = $objs
                        ->where(function ($query) use ($request) {
                            $query->where('name', 'LIKE', '%' . $request->q . '%')
                                ->orWhereHas('product', function ($query) use ($request) {
                                    $query->where('name', 'LIKE', '%' . $request->q . '%')
                                        ->orWhere('sku', 'LIKE', '%' . $request->q . '%');
                                });
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->take(100)
                        ->get()
                        ->map(function ($obj) {
                            return [
                                'id' => $obj->id,
                                'text' => $obj->fullName
                            ];
                        });
                    break;
                case 'scan':
                    $variable = $objs->with('attributes', 'units', '_product')->whereHas('units', function ($query) use ($request) {
                        $query->whereBarcode($request->barcode);
                    })->first();
                    if ($variable) {
                        $result = $variable;
                    } else {
                        $result = false;
                    }
                    break;
                default:
                    $variable = Variable::withTrashed()->with('attributes', 'units', '_product')->find($request->key);
                    if ($variable) {
                        $result = $variable;
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $objs = Variable::when(isset($request->product_id), function ($query) use ($request) {
                    $query->where('product_id', $request->product_id);
                })->withTrashed()->get();
                if ($objs) {
                    return DataTables::of($objs)
                        ->editColumn('name', function ($obj) {
                            if ($this->user->can(User::UPDATE_VARIABLE)) {
                                $color = $obj->deleted_at ? 'danger' : 'success';
                                return '<a class="btn btn-update-variable text-' . $color . ' fw-bold" data-id="' . $obj->id . '">' . ($obj->name ? $obj->name : $obj->id) . '</a>';
                            }
                            return '<span class="fw-bold">' . $obj->name . '</span>';
                        })
                        ->editColumn('status', function ($obj) {
                            return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                        })
                        ->addColumn('action', function ($obj) {
                            if (!empty($this->user->can(User::DELETE_VARIABLE))) {
                                return '
                                    <form action="' . route('admin.variable.remove') . '" method="post" class="save-form">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                        <input type="hidden" name="choice" value="' . $obj->id . '" data-id="'  . $obj->id . '"/>
                                        <button class="btn btn-link text-decoration-none btn-remove">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>';
                            }
                        })
                        ->rawColumns(['checkboxes', 'sub_sku', 'name', 'price', 'status', 'action'])
                        ->make(true);
                }
            } else {
                abort(404);
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => ['nullable', 'string', 'max:125'],
            'product_id' => ['required', 'numeric'],
            'stock_limit' => ['required', 'numeric'],
            'unit_term' => ['required', 'array'],
            'unit_term.*' => ['required', 'string', 'min:2', 'max:125'],
            'unit_barcode' => ['required', 'array'],
            'unit_barcode.*' => [
                'nullable',
                'string',
                'max:125',
                function ($attribute, $value, $fail) use ($request) {
                    $barcode = array_filter($request->input('unit_barcode'), function ($value) {
                        return !is_null($value);
                    });
                    $count = array_count_values($barcode);
                    if ($count[$value] > 1) {
                        $fail('Barcode ' . $value . ' bị trùng, hãy sửa lại.');
                    } else {
                        $checkAvailable = Unit::where('barcode', $value)
                        ->whereNull('deleted_at')->exists();
                        if ($checkAvailable) {
                            $fail('Barcode ' . $attribute . ' đã được sử dụng.');
                        }
                    }
                },
            ],
            'unit_price' => ['required', 'array'],
            'unit_price.*' => ['required', 'numeric'],
            'unit_rate' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    if (!in_array("1", $value, true)) {
                        $fail('Tỷ lệ quy đổi phải có một và chỉ một giá trị là 1');
                    }
                    if (count(array_unique($value)) !== count($value)) {
                        $fail('Các giá trị quy đổi không được trùng nhau');
                    }
                }
            ],
            'unit_rate.*' => ['required', 'numeric'],
        ];
        $request->validate($rules, self::MESSAGES);

        if (!empty($this->user->can(User::CREATE_VARIABLE))) {
            DB::beginTransaction();
            try {
                $variable = Variable::create([
                    'product_id' => $request->product_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'stock_limit' => $request->stock_limit,
                    'status' => $request->has('status'),
                ]);
                if ($variable) {
                    LogController::create('tạo', self::NAME, $variable->id);
                    $variable->assignAttributes($request->input('attributes'));
                    foreach ($request->unit_term as $key => $term) {
                        $unit = Unit::create([
                            'term' => $request->unit_term[$key],
                            'variable_id' => $variable->id,
                            'barcode' => $request->unit_barcode[$key],
                            'rate' => $request->unit_rate[$key],
                            'price' => $request->unit_price[$key],
                        ]);
                        LogController::create('tạo', 'đơn vị', $unit->id);
                        $unit->barcode = $request->unit_barcode[$key] ? $request->unit_barcode[$key] : $unit->_variable->_product->code . $unit->id;
                        $unit->save();
                    }
                }

                DB::commit();
                $response = array(
                    'status' => 'success',
                    'msg' => 'Đã tạo ' . self::NAME . ' ' . $variable->name
                );
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
                Controller::resetAutoIncrement(['variables', 'units']);
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => ['nullable', 'string', 'max:125'],
            'product_id' => ['required', 'numeric'],
            'stock_limit' => ['required', 'numeric'],
            'unit_term' => ['required', 'array'],
            'unit_term.*' => ['required', 'string', 'min:2', 'max:125'],
            'unit_barcode' => ['required', 'array'],
            'unit_barcode.*' => [
                'nullable',
                'string',
                'max:125',
                function ($attribute, $value, $fail) use ($request) {
                    $barcode = array_filter($request->input('unit_barcode'), function ($value) {
                        return !is_null($value);
                    });
                    $count = array_count_values($barcode);
                    if ($count[$value] > 1) {
                        $fail('Barcode ' . $value . ' bị trùng, hãy sửa lại.');
                    } else {
                        preg_match('/barcode\.(\d+)/', $attribute, $matches);
                        $index = $matches[1];
                        $checkAvailable = Unit::where('barcode', $value)
                        ->whereNull('deleted_at')->where('id', '!=', $request->unit_id[$index])->exists();
                        if ($checkAvailable) {
                            $fail('Barcode ' . $attribute . ' bị trùng với sản phẩm khác.');
                        }
                    }
                }
            ],
            'unit_price' => ['required', 'array'],
            'unit_price.*' => ['required', 'numeric'],
            'unit_rate' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    if (!in_array("1", $value, true)) {
                        $fail('Tỷ lệ quy đổi phải có một và chỉ một giá trị là 1');
                    }
                    if (count(array_unique($value)) !== count($value)) {
                        $fail('Các giá trị quy đổi không được trùng nhau');
                    }
                }
            ],
            'unit_rate.*' => ['required', 'numeric'],
        ];
        $request->validate($rules, self::MESSAGES);
        if (!empty($this->user->can(User::UPDATE_VARIABLE))) {
            if ($request->has('id')) {
                DB::beginTransaction();
                try {
                    $variable = Variable::find($request->id);
                    if ($variable) {
                        $variable->update([
                            'product_id' => $request->product_id,
                            'name' => $request->name,
                            'description' => $request->description,
                            'stock_limit' => $request->stock_limit,
                            'status' => $request->has('status'),
                        ]);
                        LogController::create('sửa', self::NAME, $variable->id);

                        $variable->syncAttributes($request->input('attributes'));
                        foreach ($request->unit_id as $key => $id) {
                            $unit = $id ? Unit::find($request->unit_id[$key]) : new Unit();
                            $unit->term = $request->unit_term[$key];
                            $unit->variable_id = $variable->id;
                            $unit->rate = $request->unit_id[$key] ? $unit->rate : $request->unit_rate[$key];
                            $unit->price = $request->unit_price[$key];
                            $unit->save();
                            $unit->barcode = $request->unit_barcode[$key] ? $request->unit_barcode[$key] : $variable->_product->code . $unit->id;
                            $unit->save();
                            LogController::create($id ? 'sửa' : 'tạo', 'đơn vị', $unit->id);
                        }

                        DB::commit();
                        $response = array(
                            'status' => 'success',
                            'msg' => 'Đã cập nhật ' . self::NAME . ' ' . $variable->name
                        );
                    } else {
                        DB::rollBack();
                        $response = array(
                            'status' => 'error',
                            'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                        );
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
                    Controller::resetAutoIncrement(['variables', 'units']);
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                );
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        if ($this->user->can(User::DELETE_VARIABLE)) {
            DB::beginTransaction();
            try {
                $obj = Variable::withTrashed()->find($request->choice);
                DB::table('attribute_variable')->where('variable_id', $obj->id)->delete();
                $obj->units()->withTrashed()->get()->each(function ($unit) {
                    $details = $unit->details()->withTrashed()->count();
                    $import_details = $unit->import_details()->withTrashed()->count();
                    $export_details = $unit->export_details()->withTrashed()->count();
                    if (!$details && !$import_details && !$export_details) {
                        $unit->forceDelete();
                    } else {
                        $unit->delete();
                    }
                });
                if ($obj->medicine) { // Nếu biến thể có thuốc
                    if ($obj->medicine->prescription_details->count()) { // Nếu thuốc có chi tiết đơn thuốc thì xóa mềm hết
                        $obj->medicine->dosages->each(function ($dosage) {
                            $dosage->delete();
                        });
                        $obj->medicine->delete();
                    } else { // Nếu không có chi tiết đơn thuốc nào thì xóa cứng luôn
                        $obj->medicine->dosages->each(function ($dosage) {
                            $dosage->forceDelete();
                        });
                        $obj->medicine->forceDelete();
                    }
                }
                $units = $obj->units()->withTrashed()->count();
                $medicine = $obj->medicine;
                $import_details = $obj->import_details()->withTrashed()->count();
                DB::table('attribute_variable')->where('variable_id', $obj->id)->delete();
                if (!$units && !$medicine && !$import_details) {
                    $obj->forceDelete();
                } else {
                    $obj->delete();
                }
                LogController::create("xóa", self::NAME, $obj->id);
                $response = array(
                    'status' => 'success',
                    'msg' => 'Đã xóa thành công ' . self::NAME . ' ' . $obj->name . '!'
                );
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
                Controller::resetAutoIncrement(['variables', 'units', 'medicines', 'dosages']);
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }
}
