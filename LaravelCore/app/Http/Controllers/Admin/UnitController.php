<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImportDetail;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    const NAME = 'Unit';

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
            $objs = Unit::query();
            switch ($request->key) {
                case 'list':
                    $result = $objs->get();
                    break;
                case 'search':
                    $result = $objs->with('_variable.attributes', '_variable.units', '_variable._product')
                        ->where(function ($query) use ($request) {
                            $query->where('barcode', 'LIKE', "%{$request->q}%")
                                ->orWhereHas('variable', function ($query) use ($request) {
                                    $query->where('name', 'LIKE', "%{$request->q}%")
                                        ->orWhereHas('product', function ($query) use ($request) {
                                            $query->where(function ($query) use ($request) {
                                                $query->where('name', 'LIKE', "%{$request->q}%")
                                                    ->orWhere('keyword', 'LIKE', "%{$request->q}%")
                                                    ->orWhere('slug', 'LIKE', "%{$request->q}%")
                                                    ->orWhere('sku', 'LIKE', "%{$request->q}%");
                                            });
                                        });
                                });
                        })->whereHas('variable', function ($query) {
                            $query->whereStatus(1)
                                ->whereHas('product', function ($query) {
                                    $query->where('status', '>', 0)
                                        ->whereHas('catalogues', function ($query) {
                                            $query->whereStatus(1);
                                        });
                                });
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->take(100)
                        ->get()
                        ->map(function ($obj) use ($request) {
                            $obj->import_prices = ImportDetail::where('unit_id', $obj->id)->pluck('price')->filter()->unique()->all();
                            return '<li>
                                        <a class="dropdown-item cursor-pointer btn-select-variable px-0 py-0">
                                            <input type="hidden" value="' . e(json_encode($obj)) . '">
                                            <div class="row mx-2 mb-2 align-items-center">
                                                <div class="col-12 text-wrap p-2">
                                                    <h6 class="card-title mb-0">' . $obj->_variable->fullName . ' • ' . $obj->term . '</h6>
                                                    ' . ($obj->_variable->_product->sku ? '<div class="badge bg-primary">' . $obj->_variable->_product->sku . '</div>' : '') . '
                                                    <div class="badge bg-primary">' . $obj->_variable->_product->catalogues->pluck('name')->join(', ') . '</div>
                                                    <div class="badge bg-primary">Giá ' . number_format($obj->price) . 'đ</div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>';
                        });
                    break;
                case 'select2':
                    $result = $objs->with('_variable.attributes', '_variable.units', '_variable._product')
                        ->where(function ($query) use ($request) {
                            $query->where('barcode', 'LIKE', "%{$request->q}%")
                                ->orWhereHas('variable', function ($query) use ($request) {
                                    $query->where('name', 'LIKE', "%{$request->q}%")
                                        ->orWhereHas('product', function ($query) use ($request) {
                                            $query->where(function ($query) use ($request) {
                                                $query->where('name', 'LIKE', "%{$request->q}%")
                                                    ->orWhere('keyword', 'LIKE', "%{$request->q}%")
                                                    ->orWhere('slug', 'LIKE', "%{$request->q}%")
                                                    ->orWhere('sku', 'LIKE', "%{$request->q}%");
                                            });
                                        });
                                });
                        })->whereHas('variable', function ($query) {
                            $query->whereStatus(1)
                                ->whereHas('product', function ($query) {
                                    $query->where('status', '>', 0)
                                        ->whereHas('catalogues', function ($query) {
                                            $query->whereStatus(1);
                                        });
                                });
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->take(100)
                        ->get()
                        ->map(function ($obj) {
                            return [
                                'id' => $obj->id,
                                'text' => $obj->_variable->fullName . ' • ' . $obj->term
                            ];
                        });
                    break;
                case 'scan':
                    $obj = $objs->with('_variable.attributes', '_variable.units', '_variable._product')
                        ->whereHas('variable', function ($query) {
                            $query->whereStatus(1)->whereHas('product', function ($query) {
                                $query->where('status', '>', 0)->whereHas('catalogues', function ($query) {
                                    $query->whereStatus(1);
                                });
                            });
                        })->whereBarcode($request->barcode)->first();
                    if ($obj) {
                        $obj->import_prices = ImportDetail::where('unit_id', $obj->id)->pluck('price')->filter()->unique()->all();
                        $result = $obj;
                    } else {
                        $result = false;
                    }
                    break;
                default:
                    $variable = $objs->with('_variable.attributes', '_variable.units', '_variable._product')->find($request->key);
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
                abort(404);
            } else {
                abort(404);
            }
        }
    }

    public function remove(Request $request)
    {
        foreach ($request->choices as $key => $id) {
            $obj = Unit::find($id);
            if ($obj->rate != 1) {
                $obj->delete();
                $response = array(
                    'status' => 'success',
                    'msg' => 'Deleted ' . self::NAME . ' ' . $obj->term . ' successfully!'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'At least one unit must have a conversion rate of 1!'
                );
            }
        }
        return response()->json($response, 200);
    }
}
