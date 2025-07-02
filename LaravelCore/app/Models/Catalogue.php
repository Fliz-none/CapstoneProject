<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Catalogue extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = 'catalogues';
    protected $appends = array('code', 'fullName', 'avatarUrl', 'statusStr');
    protected $fillable = [
        'slug',
        'name',
        'avatar',
        'sort',
        'parent_id',
        'status',
        'note',
        'is_featured',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    function all_products($id = null)
    {
        // Lấy danh mục cha
        $catalogue = Catalogue::with(['products', 'children.products'])->find($id ?? $this->id);
        if (!$catalogue) {
            return collect();
        }
        // Lấy sản phẩm của danh mục cha
        $products = $catalogue->products->merge(
                        $catalogue->children->flatMap(function ($child) {
                            return $child->products;
                        })
                    );
        return $products->unique('id');
    }

    public function parent()
    {
        return $this->belongsTo(Catalogue::class, 'parent_id');
    }

    public function _parent()
    {
        return $this->belongsTo(Catalogue::class, 'parent_id')->withTrashed();
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '1':
                $name = __('messages.active');
                break;
            default:
                $name = __('messages.inactive');
                break;
        }
        return $name;
    }

    public function children()
    {
        return $this->hasMany(Catalogue::class, 'parent_id');
    }

    public function getAvatarUrlAttribute()
    {
        $path = 'public/' . $this->avatar;
        if ($this->avatar && Image::where('name', $this->avatar)->first() && Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage') . '/' . $this->avatar);
        } else {
            $image = asset('admin/images/placeholder_key.png');
        }
        return $image;
    }

    public function getCodeAttribute()
    {
        return 'CATA' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getFullNameAttribute()
    {
        $str = '<span class="' . ($this->deleted_at ? 'text-danger' : 'text-primary') . '">' . $this->name . '</span>';
        return $str;
    }
}
