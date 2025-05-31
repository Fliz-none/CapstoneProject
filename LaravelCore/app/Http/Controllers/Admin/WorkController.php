<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Yajra\DataTables\Facades\DataTables;

class WorkController extends Controller
{
    const NAME = 'chấm công';

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
                case 'summary':
                    if ($request->has('range')) {
                        $explode_range = explode(' - ', $request->range);
                        $range = [Carbon::createFromFormat('d/m/Y', $explode_range[0]), Carbon::createFromFormat('d/m/Y', $explode_range[1])];
                    } else {
                        $range = [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()];
                    }
                    // Sử dụng $range trong truy vấn
                    $works =
                        Work::whereBetween('sign_checkin', $range)
                        ->whereBetween('sign_checkout', $range)
                        ->where(function ($query) use ($request) {
                            $query->when($request->has('branch_id'), function ($query) use ($request) {
                                $query->where('branch_id', $request->branch_id);
                            }, function ($query) {
                                $query->whereIn('branch_id', Auth::user()->branches->pluck('id'));
                            });
                        })->get();
                    $summarys = $works->groupBy('user_id')->map(function ($user_works, $user_id) use ($range) {
                        $total_minutes = 0;
                        foreach ($user_works as $index => $work) {
                            if ($work->real_checkin && $work->real_checkout) {
                                $sign_checkin = Carbon::parse($work->sign_checkin);
                                $sign_checkout = Carbon::parse($work->sign_checkout);
                                $real_checkin = Carbon::parse($work->real_checkin);
                                $real_checkout = Carbon::parse($work->real_checkout);

                                // Xác định thời gian checkin hợp lệ
                                $checkin = $real_checkin->lessThan($sign_checkin) ? $sign_checkin : $real_checkin;

                                // Xác định thời gian checkout hợp lệ
                                $checkout = $real_checkout->greaterThan($sign_checkout) ? $sign_checkout : $real_checkout;
                                $total_minutes += $checkout->diffInMinutes($checkin);
                            }
                        }

                        $total_hours = $total_minutes / 60;
                        $total_shifts = $user_works->count();
                        $total_late = $user_works->filter(function ($work) {
                            if ($work->real_checkin && $work->sign_checkin) {
                                return Carbon::parse($work->real_checkin)->greaterThan(Carbon::parse($work->sign_checkin));
                            }
                            return false;
                        })->count();
                        $settings = Cache::get('settings');
                        return [
                            'total_minutes' => $total_minutes,
                            'user' => $user_works->first()->user,
                            'salary' => ($total_hours * $settings['hourly_salary']) . ' '. $settings['currency'],
                            'total_hours' => floor($total_hours) . ' giờ ' . ($total_minutes % 60) . ' phút',
                            'total_shifts' => $total_shifts,
                            'total_late' => $total_late,
                        ];
                    });

                    $range = implode(' - ', array_map(function ($date) {
                        return Carbon::parse($date)->format('d/m/Y');
                    }, $range));
                    return view('admin.includes.partials.modal_work_summary', compact('summarys', 'range'))->render();
                case 'timekeeping':
                    $pageName = 'Chấm công';
                    $agent = new Agent();
                    $conditions = self::conditions();
                    $work = self::current();
                    return view('admin.timekeeping', compact('pageName', 'conditions', 'agent', 'work'));
                case 'schedule':
                    $branchIds = Auth::user()->branches->pluck('id');
                    $works = Work::whereBetween('sign_checkin', [Carbon::now()->addWeek()->startOfWeek(), Carbon::now()->addWeek()->endOfWeek()])
                        ->whereIn('branch_id', Auth::user()->branches->pluck('id'))
                        ->get();
                    $workSettings = collect(json_decode(Cache::get('settings')['work_info']));

                    $works = $works->map(function ($work) use ($workSettings) {
                        // Tìm index dựa trên sign_checkin (chỉ giờ phút)
                        $matchingIndex = $workSettings->search(function ($setting) use ($work) {
                            // Lấy giờ phút từ sign_checkin của $work và $setting
                            $workTime = Carbon::parse($work->sign_checkin)->format('H:i');
                            return isset($setting->sign_checkin) && $setting->sign_checkin === $workTime;
                        });

                        // Thêm trường index vào từng bản ghi
                        $work->index = $matchingIndex !== false ? $matchingIndex : null;

                        // Thêm ngày
                        $signCheckinDate = Carbon::parse($work->sign_checkin);
                        // Ánh xạ ngày trong tuần (Carbon: 0=Chủ nhật, 1=Thứ Hai,..., 6=Thứ Bảy)
                        $weekDay = $signCheckinDate->dayOfWeek; // 0=Sunday, ..., 6=Saturday
                        $mappedDay = $weekDay === 0 ? 6 : $weekDay - 1; // Chuẩn quốc tế là 0 là chủ nhật nên lọc ra cn còn lại trừ 1
                        // Thêm trường date vào work
                        $work->date = $mappedDay;
                        return $work;
                    });

                    // Trả về hoặc kiểm tra kết quả
                    return response()->json($works, 200);
                default:
                    $work = Work::with('user')->find($request->key);
                    if ($work) {
                        $result = $work;
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $works = Work::where(function ($query) use ($request) {
                    $query->when($request->has('branch_id'), function ($query) use ($request) {
                        $query->where('branch_id', $request->branch_id);
                    }, function ($query) {
                        $query->whereIn('branch_id', $this->user->branches->pluck('id'));
                    });
                })->orderBy('created_at', 'desc');
                $can_update_work = $this->user->can(User::UPDATE_WORK);
                $can_update_user = $this->user->can(User::UPDATE_USER);
                $can_update_branch = $this->user->can(User::UPDATE_BRANCH);
                return DataTables::of($works)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) use ($can_update_work) {
                        if ($can_update_work) {
                            $code = '<a class="btn btn-update-work fw-bold px-0 text-primary" data-id="' . $obj->id . '">' . $obj->code . '</a>';
                        } else {
                            $code = '<span class="fw-bold">' . $obj->code . '</span>';
                        }
                        return $code . '<br/><small>' . Carbon::parse($obj->created_at)->format('d/m/Y H:i') . '</small>';
                    })
                    ->filterColumn('code', function ($query, $keyword) {
                        $array = explode('/', $keyword);
                        $query->when(count($array) > 1, function ($query) use ($keyword, $array) {
                            $date = parseDate($keyword);
                            $query->when($date['year'], function ($query) use ($date) {
                                $query->whereYear('works.created_at', $date['year']);
                            })
                                ->when($date['month'], function ($query) use ($date) {
                                    $query->whereMonth('works.created_at', $date['month']);
                                })
                                ->when($date['day'], function ($query) use ($date) {
                                    $query->whereDay('works.created_at', $date['day']);
                                });
                        }, function ($query) use ($keyword) {
                            $numericKeyword = ltrim(preg_replace('/[^0-9]/', '', $keyword), '0');
                            if (!empty($numericKeyword)) {
                                $query->where('works.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->addColumn('user', function ($obj) use ($can_update_user, $can_update_branch) {
                        if ($obj->user_id) {
                            if ($can_update_user) {
                                $str = '<a class="btn btn-link text-decoration-none text-start btn-update-user p-0" data-id="' . $obj->user_id . '">' . $obj->user->fullName . '</a>';
                            } else {
                                $str = $obj->user->fullName;
                            }
                        } else {
                            $str = 'N/A';
                        }
                        if ($obj->branch_id) {
                            if ($can_update_branch) {
                                $str .= '<br/><small class="badge bg-light-info"><a class="cursor-pointer text-decoration-none text-start btn-update-branch" data-id="' . $obj->branch_id . '">' . $obj->branch->fullName . ' </a></small>';
                            } else {
                                $str .= '<br/><small class="badge bg-light-info">' . $obj->branch->fullName . '</small>';
                            }
                        }
                        return $str;
                    })
                    ->filterColumn('user', function ($query, $keyword) {
                        $query->whereHas('user', function ($query) use ($keyword) {
                            $query->where('users.name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('user', function ($query, $order) {
                        $query->orderBy('works.user_id', $order);
                    })
                    ->addColumn('check_in', function ($obj) {
                        return '<small>' . (isset($obj->real_checkin) ? Carbon::parse($obj->real_checkin)->format('d/m/Y H:i') : 'Not available') . $obj->gap_checkin() . '</small>';
                    })
                    ->filterColumn('check_in', function ($query, $keyword) {
                        $date = parseDate($keyword);
                        $query->when($date['year'], function ($query) use ($date) {
                            $query->whereYear('works.sign_checkin', $date['year']);
                        })
                            ->when($date['month'], function ($query) use ($date) {
                                $query->whereMonth('works.sign_checkin', $date['month']);
                            })
                            ->when($date['day'], function ($query) use ($date) {
                                $query->whereDay('works.sign_checkin', $date['day']);
                            });
                    })
                    ->addColumn('check_out', function ($obj) {
                        return '<small>' . (isset($obj->real_checkout) ? Carbon::parse($obj->real_checkout)->format('d/m/Y H:i') : 'Not available') . $obj->gap_checkout() . '</small>';
                    })
                    ->filterColumn('check_out', function ($query, $keyword) {
                        $date = parseDate($keyword);
                        $query->when($date['year'], function ($query) use ($date) {
                            $query->whereYear('works.sign_checkout', $date['year']);
                        })
                            ->when($date['month'], function ($query) use ($date) {
                                $query->whereMonth('works.sign_checkout', $date['month']);
                            })
                            ->when($date['day'], function ($query) use ($date) {
                                $query->whereDay('works.sign_checkout', $date['day']);
                            });
                    })
                    ->editColumn('images', function ($obj) {
                        return '<img src="' . $obj->image_checkin_url . '" class="thumb cursor-pointer object-fit-cover" style="width: 80px; height: 80px"> <img src="' . $obj->image_checkout_url . '" class="thumb cursor-pointer object-fit-cover" style="width: 80px; height: 80px">';
                    })
                    ->filterColumn('images', function ($query, $keyword) {
                        $query->where('id', 'like', "%" . $keyword . "%");
                    })
                    ->orderColumn('images', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->addColumn('action', function ($obj) {
                        return '<div class="d-flex justify-content-end">
                                    <form method="post" action="' . route('admin.work.remove') . '" class="save-form">
                                        <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                                        <button class="btn btn-link text-decoration-none btn-remove" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>';
                    })
                    ->rawColumns(['checkboxes', 'code', 'user', 'check_in', 'check_out', 'images', 'action'])
                    ->make(true);
            } else {
                if (isset($request->display) && $request->display == 'list') {
                    $pageName = self::NAME . ' management';
                    return view('admin.work_list', compact('pageName'));
                }
                $pageName = 'Work Schedule';
                $startOfWeek = $request->has('monday')
                    ? Carbon::parse($request->monday)
                    : Carbon::now()->startOfWeek();
                $endOfWeek = $startOfWeek->copy()->addDays(7);
                $users = User::with([
                    'works' => function ($work) use ($startOfWeek, $endOfWeek) {
                        $work->whereBetween('sign_checkin', [$startOfWeek, $endOfWeek]);
                    }
                ])->whereNotIn('id', [1])
                    ->permission(User::ACCESS_ADMIN)
                    ->where(function ($query) use ($request) {
                        $query->when($request->has('branch_id'), function ($query) use ($request) {
                            $query->where('main_branch', $request->branch_id);
                        }, function ($query) {
                            $query->whereIn('main_branch', Auth::user()->branches->pluck('id'));
                        });
                    })->get();
                $days = collect(range(0, 6))->map(function ($day) use ($startOfWeek) {
                    return $startOfWeek->copy()->addDays($day);
                });
                return view('admin.work_calendar', compact('pageName', 'users', 'days'));
            }
        }
    }

    public function timekeeping(Request $request)
    {
        try {
            $request->validate([
                'work_image' => 'required|string', // Validate base64 string
            ], [
                'work_image.required' => 'The system could not get the attendance image.',
                'work_image.string' => 'Invalid image data.',
            ]);

            $work = self::current();
            if ($work) {
                // Giải mã chuỗi base64 thành dữ liệu nhị phân
                $image = base64_decode(explode(',', $request->work_image)[1]);
                $imageName = Str::slug(Auth::user()->name) . Carbon::now()->format('_YmdHis.') . 'jpg'; //cấu hình ngoài viêw là jpg
                Storage::disk('public')->put('work/' . $imageName, $image);

                if (!$work->real_checkin) {
                    $work->update([
                        'real_checkin' => Carbon::now(),
                        'image_checkin' => $imageName,
                    ]);
                    $response = [
                        'status' => 'success',
                        'msg' => 'Checkin successful!',
                        'work' => $work
                    ];
                } else { // Chấm ra
                    $work->update([
                        'real_checkout' => Carbon::now(),
                        'image_checkout' => $imageName,
                    ]);
                    $response = [
                        'status' => 'success',
                        'msg' => 'Checkout successful!'
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'msg' => 'No work shift needs to be clocked in!'
                ];
            }
            return redirect()->back()->with('response', $response);
        } catch (\Throwable $th) {
            $response = array(
                'status' => 'danger',
                'msg' => 'An error occurred, please contact the software developer for assistance!'
            );
            return redirect()->back()->with('response', $response);
        }
    }

    public function update(Request $request)
    {
        if (!empty($this->user->can(User::UPDATE_WORK))) {
            // Validate thời gian checkin không thể vượt qua giờ checkout
            $request->validate([
                'real_checkin' => 'nullable|date_format:H:i',
                'real_checkout' => 'nullable|date_format:H:i|after:real_checkin',
            ], [
                'real_checkout.after' => 'Checkout time must be later than check-in time.',
                'real_checkin.date_format' => 'Invalid check-in time format.',
                'real_checkout.date_format' => 'Invalid checkout time format.',
            ]);

            $work = Work::find($request->id);
            $today = Carbon::parse($work->sign_checkin)->toDateString();

            // Tạo datetime từ ngày sign_checkin và giờ từ request
            $realCheckin = $request->real_checkin ? Carbon::parse($today . ' ' . $request->real_checkin) : null;
            $realCheckout = $request->real_checkout ? Carbon::parse($today . ' ' . $request->real_checkout) : null;

            $work->update([
                'real_checkin' => $realCheckin,
                'real_checkout' => $realCheckout,
            ]);

            $response = array(
                'status' => 'success',
                'msg' => self::NAME . ' ' . $work->code . ' has been updated successfully.',
            );
        } else {
            return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
        }
        return response()->json($response, 200);
    }

    /**
     *  Đăng ký lịch cho admin.
     * @return object
     * */
    public function schedule(Request $request)
    {
        try {
            if (!empty($this->user->can(User::CREATE_WORK))) {
                $shifts = explode('-', $request->shift);
                $sign_checkin = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $shifts[0]);
                $sign_checkout = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $shifts[1]);
                $work_info = json_decode(cache()->get('settings')['work_info']);

                $work = Work::where('user_id', $request->user_id)->where('branch_id', $request->main_branch)->where('sign_checkin', $sign_checkin)->where('sign_checkout', $sign_checkout)->first();
                if (is_null($work)) { // Chưa đăng ký thì tạo mới

                    //Validate số lượng nhân viên trong một ca làm việc
                    $shift = collect($work_info)->first(function ($info) use ($sign_checkin, $sign_checkout) {
                        return isset($info->sign_checkin, $info->sign_checkout) && $info->sign_checkin === $sign_checkin->format('H:i') && $info->sign_checkout === $sign_checkout->format('H:i');
                    });
                    $registered = Work::with('branch')->where('branch_id', $request->main_branch)
                        ->where('sign_checkin', $sign_checkin)->where('sign_checkout', $sign_checkout)->get();
                    if ($shift && isset($shift->staff_number) && $registered->count() >= $shift->staff_number) {
                        $branch_name = $registered->map(function ($work, $index) {
                            return $work->branch->name; // Thêm index vào tên chi nhánh
                        })->unique()->join(', ');
                        return response()->json(['errors' => ['has_enough' => ['This shift at ' . $branch_name . ' already has enough registered employees.']]], 422);
                    }
                    unset($work_info->allow_self_register); // Loại bỏ trường 'allow_self_register'
                    $shiftFound = collect($work_info)->first(function ($shift) use ($shifts) {
                        return $shift->sign_checkin === $shifts[0] && $shift->sign_checkout === $shifts[1];
                    }); // Biến trong setting có giá trị băngf giá trị mà user chọn
                    Work::create([
                        'user_id' => $request->user_id,
                        'branch_id' => $request->main_branch,
                        'shift_name' => $shiftFound->shift_name,
                        'sign_checkin' => $sign_checkin,
                        'sign_checkout' => $sign_checkout,
                    ]);
                    $response = array(
                        'status' => 'success',
                        'msg' => 'Successfully registered shift ' . $shiftFound->shift_name . ' for ' . User::find($request->user_id)->name
                    );
                } else { // Có đăng ký thì xóa
                    $work->delete();
                    $response = array(
                        'status' => 'success',
                        'msg' => 'Successfully canceled registration for ' . $work->shift_name . ' for ' . User::find($request->user_id)->name
                    );
                }
                return response()->json($response, 200);
            } else {
                return response()->json(['errors' => ['role' => ['You do not have permission!']]], 422);
            }
        } catch (\Throwable $th) {
            $response = array(
                'status' => 'danger',
                'msg' => 'An error occurred, please contact the software developer for assistance!'
            );
            return response()->json($response, 200);
        }
    }


    /**
     *  Các biến hiển thị điều kiện của chấm công.
     * @return array
     * */
    public static function conditions()
    {
        $isCheckin = false;
        $work = self::current();
        if (!is_null($work)) {
            if (is_null($work->real_checkin) && is_null($work->real_checkout)) {
                $isCheckin = true;
            }
            // elseif (!is_null($work->real_checkin) && is_null($work->real_checkout)) {
            //     $isCheckin = false;
            // }
            $isCheckoutTime = $work->sign_checkin < Carbon::now();
        } else {
            $isCheckoutTime = false;
        }
        return ['isCheckin' => $isCheckin, 'hasWork' => !is_null($work), 'isCheckoutTime' => $isCheckoutTime];
    }

    /**
     *  Lấy ca làm việc hiện tại cần chấm công của nhân viên.
     * @return \App\Models\Work|null
     * */
    public static function current()
    {
        $works = Work::whereBetween('sign_checkin', [Carbon::today(), Carbon::tomorrow()])
            ->whereBetween('sign_checkout', [Carbon::today(), Carbon::tomorrow()])
            ->where('branch_id', Auth::user()->main_branch)
            ->where('user_id', Auth::id())
            // ->where('sign_checkout', '>', Carbon::now()) // Lấy các bảng ghi còn có thể checkin - checkout
            ->orderBy('sign_checkin', 'asc')
            ->get();
        foreach ($works as $work) {
            if (is_null($work->real_checkin) || is_null($work->real_checkout)) {
                return $work;
            }
        }
        return null;
    }

    /**
     *  Các biến hiển thị điều kiện của chấm công.
     * @return object
     * */
    public function remove(Request $request)
    {
        $success = [];
        foreach ($request->choices as $key => $id) {
            $obj = Work::find($id);
            $obj->delete();
            LogController::create("delete", self::NAME, $obj->id);
            array_push($success, $obj->name);
        }
        if (count($success)) {
            $msg = 'Successfully deleted ' . self::NAME . ' ' . implode(', ', $success);
        }
        $response = array(
            'status' => 'success',
            'msg' => $msg
        );
        return response()->json($response, 200);
    }
}
