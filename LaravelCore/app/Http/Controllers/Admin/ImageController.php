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
    const NAME = 'Image';

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
                $images = Image::with('author')->orderBy('id', 'DESC')->get();
                return DataTables::of($images->toArray())->setTotalRecords($images->count())->make(true);
            } else {
                $pageName = self::NAME . ' management';
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
            ]);
            LogController::create('create', self::NAME . ' ' . $image->name,  $image->id);

            $response = array(
                'status' => 'success',
                'msg' => 'Upload successfully!',
            );

            return response()->json($response, 200);
        } catch (\Exception $e) {
            log_exception($e);
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|regex:/^[a-zA-Z0-9\-]+$/',
        ];
        $messages = [
            'name.required' => Controller::NOT_EMPTY,
            'name.regex' => 'The name must only contain lowercase letters, uppercase letters, numbers, and hyphens.',
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
                $image->save();
                LogController::create('delete', self::NAME . ' ' . $image->name,  $image->id);
            } else {
                $image->delete();
                $response = array(
                    'status' => 'error',
                    'msg' => 'The file no longer exists! The data about the file will be deleted from the system.',
                );
            }
            $response = array(
                'status' => 'success',
                'msg' => 'Updated ' . self::NAME . ' ' . $image->name,
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            log_exception($e);
            return back()->withError($e->getMessage())->withInput();
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
                        'msg' => 'Cannot delete ' . $id,
                    );
                    return response()->json($response, 200);
                    break;
                }
            }
            $response = array(
                'status' => 'success',
                'msg' => 'Deleted ' . self::NAME . ' ' . implode(', ', $names)
            );
        } else {
            $response = array(
                'status' => 'error',
                'msg' => 'Unable to process the request! Please try again later.',
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
