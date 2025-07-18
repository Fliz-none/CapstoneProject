<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    const NAME = 'Log';

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
    public function index(Request $request)
    {
        if (isset($request->key)) {
            switch ($request->key) {
                case 'list':
                    $ids = json_decode($request->ids);
                    $result = Log::orderByDesc('created_at')
                        ->when(count($ids), fn($query) => $query->whereIn('id', $ids))
                        ->limit(500)
                        ->get();
                    break;

                case 'search':
                    $result = Log::where(function ($query) use ($request) {
                        $query->where('action', 'like', "%{$request->q}%")
                            ->orWhere('type', 'like', "%{$request->q}%")
                            ->orWhere('object', 'like', "%{$request->q}%");
                    })
                        ->get()
                        ->map(function ($log) {
                            return '<li class="list-group-item list-group-item-action cursor-pointer rounded-3 border-0">
                                    Action: ' . $log->action . ', Type: ' . $log->type . '
                                </li>';
                        });
                    break;

                default:
                    return response()->json(['error' => 'Invalid key'], 400);
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $logs = Log::with(['_user', 'branch'])->orderByDesc('created_at');
                return DataTables::of($logs)
                    ->addColumn('code', function ($log) {
                        $code = '<a class="cursor-pointer btn-detail-log text-primary fw-bold" data-id="' . $log->id . '">' . $log->code . '</a>';
                        return $code . '<br/><small>' . optional($log->created_at)->format('d/m/Y H:i') . '</small>';
                    })
                    ->filterColumn('code', function ($query, $keyword) {
                        $array = explode('/', $keyword);
                        $query->when(count($array) > 1, function ($query) use ($keyword, $array) {
                            $date = parseDate($keyword);
                            $query->when($date['year'], function ($query) use ($date) {
                                $query->whereYear('logs.created_at', $date['year']);
                            })
                                ->when($date['month'], function ($query) use ($date) {
                                    $query->whereMonth('logs.created_at', $date['month']);
                                })
                                ->when($date['day'], function ($query) use ($date) {
                                    $query->whereDay('logs.created_at', $date['day']);
                                });
                        }, function ($query) use ($keyword) {
                            $numericKeyword = ltrim(preg_replace('/[^0-9]/', '', $keyword), '0');
                            if (!empty($numericKeyword)) {
                                $query->where('logs.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->editColumn('user_id', function ($log) {
                        return '<span class="fw-bold text-primary">' . $log->user->name . '</span>';
                    })
                    ->filterColumn('user_id', function ($query, $keyword) {
                        $query->whereHas('user', function ($query) use ($keyword) {
                            $query->where('name', 'like', '%' . $keyword . '%');
                        });
                    })

                    // ->editColumn('action', function ($log) {
                    //     return '<span class="fw-bold">' . $log->action . '</span>';
                    // })
                    ->editColumn('action', function ($log) {
                        switch ($log->action) {
                            case 1:
                                $actionText = __('messages.create');
                                break;
                            case 2:
                                $actionText = __('messages.update');
                                break;
                            case 3:
                                $actionText = __('messages.delete');
                                break;
                            default:
                                $actionText = __('messages.unknown');
                                break;
                        }
                        return '<span class="fw-bold">' . $actionText . '</span>';
                    })

                    ->filterColumn('action', function ($query, $keyword) {
                        $query->where('action', 'like', '%' . $keyword . '%');
                    })
                    ->editColumn('type', function ($log) {
                        return '<span>' . $log->type . '</span>';
                    })
                    ->filterColumn('type', function ($query, $keyword) {
                        $query->where('type', 'like', '%' . $keyword . '%');
                    })
                    ->editColumn('ip', function ($log) {
                        return $log->ip;
                    })
                    ->filterColumn('ip', function ($query, $keyword) {
                        $query->where('geolocation', 'like', '%' . $keyword . '%');
                    })
                    ->filterColumn('agent', function ($query, $keyword) {
                        $query->where('agent', 'like', '%' . $keyword . '%');
                    })
                    ->filterColumn('platform', function ($query, $keyword) {
                        $query->where('platform', 'like', '%' . $keyword . '%');
                    })
                    ->filterColumn('created_at', function ($query, $keyword) {
                        $query->whereDate('created_at', $keyword);
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->rawColumns(['code', 'user_id', 'action', 'type'])
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.logs', compact('pageName'));
            }
        }
    }




    static function create($action, $object, $object_id, $ip = null)
    {
        $agent = new Agent();
        $geolocation = Http::get('https://ipinfo.io/' . session('ip') . '/json?token=d89e4a0555c438')->json();
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => $action,
            'type' => $object,
            'object' => $object_id,
            'geolocation' => json_encode($geolocation),
            'agent' => $agent->browser() . ' ' . $agent->version($agent->browser()),
            'platform' => $agent->platform() . ' ' . $agent->version($agent->platform()),
            'device' => ($agent->isRobot()) ? $agent->robot() : $agent->device(),
        ]);
    }

    public function show($id)
    {
        $log = Log::find($id);
        if (!$log) {
            return response()->json(['error' => 'Log not found'], 404);
        }

        $beforeChange = $log->before_change ? self::hydrateModelFromLog($log->type, $log->before_change) : null;
        $afterChange = $log->after_change ? self::hydrateModelFromLog($log->type, $log->after_change) : null;

        $log->before_change = $beforeChange;
        $log->after_change = $afterChange;
        return response()->json($log);
    }


    private static function getModelClassFromType(string $type): ?string
    {
        $className = 'App\\Models\\' . Str::studly($type);

        return class_exists($className) ? $className : null;
    }

    private static function hydrateModelFromLog(string $type, ?string $jsonData): ?\Illuminate\Database\Eloquent\Model
    {
        if (!$jsonData)
            return null;
        $modelClass = self::getModelClassFromType($type);
        if (!$modelClass)
            return null;

        $dataArray = json_decode($jsonData, true);
        if (!$dataArray)
            return null;

        return (new $modelClass)->newFromBuilder($dataArray);
    }
}
