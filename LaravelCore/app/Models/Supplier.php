<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'suppliers';
    protected $appends = ['code', 'fullName', 'statusStr'];
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'organ',
        'status',
        'note',
    ];
    public function imports()
    {
        return $this->hasMany(Import::class);
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

    public function getCodeAttribute()
    {
        return 'SUP' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getFullNameAttribute()
    {
        $str = '<span class="' . ($this->deleted_at ? 'text-danger' : 'text-primary') . '">' . $this->name . '</span>';
        return $str;
    }
}
