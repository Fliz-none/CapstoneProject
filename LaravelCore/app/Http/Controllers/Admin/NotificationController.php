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
    const NAME = 'notification';
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
        } else {
            if ($request->ajax()) {
            } else {
                $pageName = self::NAME . ' management'; 
                return view('admin.notifications', compact('pageName'));
            }
        }
    }

    static function create($text)
    {
        try {
            $noti = Notification::create([
                'description' => sprintf($text)
            ]);
            return $noti;
        } catch (\Throwable $e) {
            log_exception($e);
            return null;
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
        cache()->forget('notifications');
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
            'msg' => 'Notification turned off!',
            'template' => view('admin.includes.notifications', compact('notis'))->render()
        ];
        return response()->json($response, 200);
    }
}
