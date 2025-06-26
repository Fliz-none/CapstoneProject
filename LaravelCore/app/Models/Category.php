<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    protected $appends = ['fullName', 'statusStr'];
    protected $fillable = [
        'slug',
        'name',
        'sort',
        'status',
        'note',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
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

    public function canRemove()
    {
        $relationships = [
            'posts',
        ];
        foreach ($relationships as $relationship) {
            if (count($this->$relationship)) {
                return false;
            }
        }
        return true;
    }

    public function getFullNameAttribute()
    {
        $str = '<span class="' . ($this->deleted_at ? 'text-danger' : 'text-primary') . '">' . $this->name . '</span>';
        return $str;
    }
}
