<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'posts';
    protected $appends = ['code', 'fullName', 'imageUrl', 'typeStr', 'statusStr'];
    protected $fillable = [
        'slug',
        'title',
        'author_id',
        'category_id',
        'excerpt',
        'content',
        'image',
        'type',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function _category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function _author()
    {
        return $this->belongsTo(User::class, 'author_id')->withTrashed();
    }

    public function getCodeAttribute()
    {
        return 'BV' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getFullNameAttribute()
    {
        $str = '<span class="' . ($this->deleted_at ? 'text-danger' : 'text-primary') . '">' . $this->title . '</span>';
        return $str;
    }

    public function getTypeStrAttribute()
    {
        switch ($this->type) {
            case '1':
                $name = 'Page';
                break;
            default:
                $name = 'Post';
                break;
        }
        return $name;
    }

    public function getImageUrlAttribute()
    {
        $path = 'public/' . $this->image;
        if ($this->image && Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage/') . $this->image);
        } else {
            $image = asset('admin/images/placeholder_key.png');
        }
        return $image;
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '2':
                $name = '<span class="badge bg-success">Nổi bật</span>';
                break;
            case '1':
                $name = '<span class="badge bg-info">Xuất bản</span>';
                break;
            default:
                $name = '<span class="badge bg-danger">Không hiển thị</span>';
                break;
        }
        return $name;
    }

    public function createdAt()
    {
        return ($this->created_at) ? Carbon::parse($this->created_at)->format('H:i:s d/m/Y') : '';
    }

    public function createdDate()
    {
        return ($this->created_at) ? Carbon::parse($this->created_at)->format('Y-m-d') : '';
    }

    public function createdTime()
    {
        return ($this->created_at) ? Carbon::parse($this->created_at)->format('H:i:s') : '';
    }

    public function canRemove()
    {
        $relationships = [
            // 'category',
            // 'author'
        ];
        foreach ($relationships as $relationship) {
            if (count($this->$relationship->get())) {
                return false;
            }
        }
        return true;
    }
}
