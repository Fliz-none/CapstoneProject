<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    const NAME = 'thông báo';
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
            abort(404);
            // switch ($request->key) {
            //     case 'list':
            //         return response()->json(cache()->get('notifications_' . Auth::user()->company_id), 200);
            //         break;

            //     default:
            //         switch ($request->action) {
            //             default:
            //                 # code...
            //                 break;
            //         }
            //         break;
            // }
        } else {
            if ($request->ajax()) {
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.notifications', compact('pageName'));
            }
        }
    }

    static function create($text, $company = null)
    {
        try {
            $noti = Notification::create([
                'description' => sprintf($text),
                'company_id' => $company ?? Auth::user()->company_id,
            ]);
            return $noti;
        } catch (\Throwable $e) {
            Log::error('Có lỗi xảy ra: ' . $e->getMessage());
            Log::error('Chi tiết lỗi:', ['exception' => $e]);
        }
    }

    static function push($noti, $users)
    {
        $data = $users->map(function ($user) use ($noti) {
            return [
                'notification_id' => $noti->id,
                'user_id' => $user->id,
                'status' => 0,
            ];
        })->toArray();
        DB::table('notification_user')->insert($data);
        cache()->forget('notifications_' . Auth::user()->company_id);
    }

    public function mark(Request $request)
    {
        DB::table('notification_user')->where('user_id', Auth::id())->where('notification_id', $request->id)->update(['status' => 1]);
        if (!DB::table('notification_user')->where('notification_id', $request->id)->where('status', 0)->count()) {
            optional(Notification::find($request->id))->forceDelete();
        }
        $notis = $this->user->notifications()->wherePivot('status', 0)->select('notifications.*')->orderBy('id', 'DESC')->get();
        $response = [
            'status' => 'success',
            'msg' => 'Đã tắt thông báo',
            'template' => view('admin.includes.notifications', compact('notis'))->render()
        ];
        return response()->json($response, 200);
    }
}
