<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class Image extends Model
{
    protected $table = 'images';
    protected $appends = array('link');
    protected $fillable = [
        'name',
        'alt',
        'caption',
        'author_id',
        'created_at'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function _author()
    {
        return $this->belongsTo(User::class, 'author_id')->withTrashed();
    }

    public function getLinkAttribute()
    {
        $path = 'public/' . $this->name;
        if (Image::where('name', $this->name)->count() && Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', 'storage') . '/' . $this->name);
        } else {
            $image = asset('admin/images/placeholder_key.png');
        }
        return $image;
    }

    public function rotate($path, $direction = 'clockwise')
    {
        if (!Storage::exists($path)) {
            return false;
        }
        $imageContent = Storage::get($path);
        $image = InterventionImage::make($imageContent);
        $degrees = $direction === 'clockwise' ? -90 : 90;
        $image->rotate($degrees);
        Storage::put($path, (string) $image->encode());
        return $path;
    }

    // public function getSizeAttribute()
    // {
    //     $path = 'public/' . $this->name;
    //     if (Storage::exists($path)) {
    //         $size = Storage::size($path);
    //         $result = $this->formatSizeUnits($size);
    //     } else {
    //         $result = 0;
    //     }
    //     return $result;
    // }

    // public function getDimensionAttribute()
    // {
    //     $path = 'public/' . $this->name;
    //     if (Storage::exists($path)) {
    //         try {
    //             $dimension = getimagesize($this->link);
    //         } catch (\Throwable $th) {
    //             $dimension = 0;
    //         }
    //         $result = $dimension ? $dimension[0] . '×' . $dimension[1] : '';
    //     } else {
    //         $result = '';
    //     }
    //     return $result;
    // }

    // Phương thức chuyển đổi dung lượng file sang đơn vị KB hoặc MB
    private function formatSizeUnits($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
