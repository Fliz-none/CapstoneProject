<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    const NAME = 'hình ảnh';

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin','auth']);
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
                default:
                    $image = Image::find($request->key);
                    if ($image) {
                        return response()->json($image);
                    } else {
                        abort(404);
                    }
                    break;
            }
        } else {
            if ($request->ajax()) {
                $images = Image::where('images.company_id', $this->user->company_id)->with('author')->orderBy('id', 'DESC')->get();
                return DataTables::of($images->toArray())->setTotalRecords($images->count())->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.images', compact('pageName'));
            }
        }
    }

    public function upload(Request $request)
    {
        try {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $tmp = explode('.', $imageName);
            $path = 'public/' . Str::slug($tmp[0]) . '.' . $tmp[count($tmp) - 1];
            $imageName = Str::slug($tmp[0]) . ((Storage::exists($path)) ? Carbon::now()->format('-YmdHis.') : '.') . $tmp[count($tmp) - 1];
            $uploadedImages[] = $image->storeAs('public/', $imageName);

            $image = Image::create([
                'name' => $imageName,
                'author_id' => $this->user->id,
                'company_id' => $this->user->company_id,
            ]);
            LogController::create('tạo', self::NAME . ' ' . $image->name,  $image->id);

            $response = array(
                'status' => 'success',
                'msg' => 'Upload thành công!',
            );

            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
            return back()->withError($e)->withInput();
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|regex:/^[a-zA-Z0-9\-]+$/',
        ];
        $messages = [
            'name.required' => 'Đừng để trống thông tin này!',
            'name.regex' => 'Tên chỉ được chứa chữ viết thường, chữ viết hoa, số và ký tự gạch ngang.',
        ];
        $request->validate($rules, $messages);
        try {
            $image = Image::find($request->id);
            $ext = explode('.', $image->name);
            $newName = $request->name . '.' . $ext[count($ext) - 1];
            if ($image) {
                if ($newName == $image->name) {
                    $imageName = $image->name;
                } else {
                    $checkPath = 'public/' . $newName;
                    if (Storage::exists($checkPath)) {
                        $imageName = $request->name . Carbon::now()->format('YmdHis') . '.' . $ext[count($ext) - 1];
                    } else {
                        $imageName = $newName;
                    }
                    $currentPath = 'public/' . $image->name;
                    $newPath = 'public/' . $imageName;
                    // Đổi tên tệp trong thư mục storage
                    Storage::move($currentPath, $newPath);
                }
                $image->name = $imageName;
                $image->alt = $request->alt;
                $image->caption = $request->caption;
                $image->company_id = $this->user->company_id;
                $image->save();
                LogController::create('xóa', self::NAME . ' ' . $image->name,  $image->id);
            } else {
                $image->delete();
                $response = array(
                    'status' => 'error',
                    'msg' => 'Tập tin không còn tồn tại! Dữ liệu về tập tin sẽ được xoá khỏi hệ thống.',
                );
            }
            $response = array(
                'status' => 'success',
                'msg' => 'Đã cập nhật ' . self::NAME . ' ' . $image->name,
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error('Có lỗi xảy ra: ' . $e->getMessage() . ';' . PHP_EOL .
                        'URL truy vấn: "' . request()->fullUrl() . '";' . PHP_EOL .
                        'Dữ liệu nhận được: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                        'User ID: ' . (Auth::check() ? Auth::id() : 'Khách') . ';' . PHP_EOL .
                        'Chi tiết lỗi: ' . $e->getTraceAsString()
                    );
            return back()->withError($e)->withInput();
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax() && $request->choices) {
            $names = [];
            foreach ($request->choices as $id) {
                if ($this->delete_exec($id)) {
                    array_push($names, $id);
                } else {
                    $response = array(
                        'status' => 'error',
                        'msg' => 'Không thể xóa ' . $id,
                    );
                    return response()->json($response, 200);
                    break;
                }
            }
            $response = array(
                'status' => 'success',
                'msg' => 'Đã xoá ' . self::NAME . ' ' . implode(', ', $names)
            );
        } else {
            $response = array(
                'status' => 'error',
                'msg' => 'Không thể thực hiện yêu cầu.',
            );
        }
        return response()->json($response, 200);
    }

    static function delete_exec($id)
    {
        $image = Image::find($id);
        if ($image) {
            $path = 'public/' . $image->name;
            LogController::create('xóa', self::NAME . ' ' . $image->name,  $image->id);
            $image->delete();
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
            return true;
        } else {
            return false;
        }
    }
}
