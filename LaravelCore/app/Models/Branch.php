<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';
    protected $appends = ['code', 'fullName', 'statusStr'];

    protected $fillable = [
        'name',
        'phone',
        'address',
        'note',
        'status',
        //'ip_address'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    //Quản lý cart
    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '1':
                $name = __('messages.active');
                break;

            default:
                $name = __('messages.active');
                break;
        }
        return $name;
    }

    public function getAddressObjectAttribute()
    {
        return json_decode($this->address) ?? (object) ['lng' => 0, 'lat' => 0, 'address' => ''];
    }
    
    public function getCodeAttribute()
    {
        return 'BRA' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getFullNameAttribute()
    {
        $str = '<span class="' . ($this->deleted_at ? 'text-danger' : 'text-primary') . '">' . $this->name . '</span>';
        return $str;
    }
}
