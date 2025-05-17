<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Version;
use Illuminate\Support\Facades\DB;

class VersionController extends Controller
{
    const NAME = 'Version',
        RULES = [
            'name' => ['required', 'string', 'min:2', 'max:125'],
            'description' => ['required', 'string'],
        ],
        MESSAGES = [
            'name.required' => Controller::NOT_EMPTY,
            'name.string' => Controller::DATA_INVALID,
            'name.min' => Controller::MIN,
            'name.max' => Controller::MAX,
            'description.required' => Controller::NOT_EMPTY,
            'description.string' => Controller::DATA_INVALID,
        ];

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
        $objs = Version::select('*');
        if (isset($request->key)) {
            switch ($request->key) {
                default:
                    $version = $objs->find($request->key);
                    if ($version) {
                        if ($request->action == 'preview') {
                            return view('admin.templates.previews.version', ['version' => $version]);
                        }
                        return response()->json($version, 200);
                    } else {
                        abort(404);
                    }
                    break;
            }
        } else {
            if ($request->ajax()) {
                return DataTables::of($objs)
                    ->editColumn('name', function ($obj) {
                        if (!empty($this->user->can(User::UPDATE_VERSION))) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-version" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        } else {
                            return $obj->name;
                        }
                    })
                    ->editColumn('description', function ($obj) {
                        $description = $obj->description;
                        $htmlContent = '<html><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . $description . '</html>';
                        $dom = new \DOMDocument;
                        libxml_use_internal_errors(true);
                        $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                        libxml_clear_errors();

                        $paragraphs = collect();
                        foreach ($dom->getElementsByTagName('p') as $paragraph) {
                            $paragraphs->push($dom->saveHTML($paragraph));
                        }
                        $firstThreeParagraphs = $paragraphs->take(3);
                        if ($paragraphs->count() > 3) {
                            $firstThreeParagraphs->push('<p>...</p>');
                        }

                        return $firstThreeParagraphs->implode("\n");
                    })
                    ->addColumn('action', function ($obj) {
                        if (!empty($this->user->can(User::DELETE_VERSION))) {
                            return '
                        <form action="' . route('admin.version.remove') . '" method="post" class="save-form">
                            <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                            <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="'  . $obj->id . '"/>
                            <button type="submit" class="btn btn-link text-decoration-none btn-remove">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>';
                        }
                    })
                    ->addColumn('user', function ($obj) {
                        if ($obj->user_id) {
                            if (!empty($this->user->can(User::READ_USER))) {
                                return '<a class="btn btn-link text-decoration-none text-start btn-update-user" data-id="' . $obj->user_id . '">' . $obj->_user->name . '</a>';
                            } else {
                                return $obj->_user->name;
                            }
                        } else {
                            return 'N/A';
                        }
                    })
                    ->rawColumns(['checkboxes', 'name', 'user', 'description', 'action'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.versions', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::CREATE_VERSION))) {
            $version = Version::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => Auth::id(),
            ]);
            $str = '<div class="row">
                        <a class="d-flex align-items-center cursor-pointer fw-bold btn-preview preview-version text-primary py-2" data-url="' . getPath(route('admin.version')) . '" data-id="' . $version->id . '">
                            <div class="col-2 px-0 d-flex justify-content-center">
                                <div class="notification-icon bg-primary">
                                    <i class="bi bi-database-fill-up"></i>
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="notification-text text-wrap">
                                    <p class="notification-title fw-bold">System Upgrade Notice</p>
                                    <small class="notification-subtitle">The software has just been updated. Click here to view the details.</small>
                                </div>
                            </div>
                        </a>
                    </div>';
            $noti = NotificationController::create(cleanStr($str));
            $data_noti = User::permission(User::ACCESS_ADMIN)->get()->map(function ($user) use ($noti) {
                return [
                    'notification_id' => $noti->id,
                    'user_id' => $user->id,
                    'status' => 0,
                ];
            })->toArray();
            DB::table('notification_user')->insert($data_noti);
            $response = array(
                'status' => 'success',
                'msg' => 'Created ' . self::NAME . ': ' . $version->name
            );
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);
        if (!empty($this->user->can(User::UPDATE_VERSION))) {
            if ($request->has('id')) {
                $version = Version::updateOrCreate([
                    'id' => $request->id
                ], [
                    'name' => $request->name,
                    'description' => $request->description,
                    'user_id' => Auth::id(),
                ]);

                $response = array(
                    'status' => 'success',
                    'msg' => 'Updated ' . self::NAME . ': ' . $version->name
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'msg' => 'An error occurred, please reload the page and try again!'
                );
            }
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $msg = [];
        foreach ($request->choices as $key => $id) {
            $obj = Version::find($id);
            if ($obj) {
                $obj->delete();
                array_push($msg, $obj->name);
            }
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Successfully deleted ' . self::NAME . ' ' . implode(', ', $msg)
        );
        return  response()->json($response, 200);
    }
}
