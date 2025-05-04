<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Log;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    const NAME = 'nhật ký';

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
                    $result = Log::where('logs.company_id', $this->user->company_id)
                        ->orderBy('created_at', 'DESC')
                        ->when(count($ids), function ($query) use ($ids) {
                            $query->whereIn('id', $ids);
                        })->get();
                    break;

                case 'search':
                    $result = Log::where('logs.company_id', $this->user->company_id)
                        ->where(function ($query) use ($request) {
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
                $logs = Log::with(['_user', 'branch'])->where('logs.company_id', $this->user->company_id); //Eager Loading
                return DataTables::of($logs)
                    ->addColumn('code', function ($log) {
                        $code = '<span class="fw-bold text-success">' . $log->code . '</span>';
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
                    ->editColumn('action', function ($log) {
                        return '<span class="fw-bold">' . $log->action . '</span>';
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
                    ->rawColumns(['code', 'user_id', 'company_id', 'action', 'type'])
                    ->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.logs', compact('pageName'));
            }
        }
    }

    static function create($action, $object, $object_id, $ip = null)
    {
        $agent = new Agent();
        $geolocation = Http::get('https://ipinfo.io/' . session('ip') . '/json?token=d89e4a0555c438')->json();
        Log::create([
            'company_id' => Auth::user()->company_id,
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
}
