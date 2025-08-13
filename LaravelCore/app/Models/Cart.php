<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'note'];
    protected $with = ['items.unit.variable.product', 'items.unit.variable.product.catalogues:id,name,slug', 'items.stock._import_detail._import._warehouse._branch'];
    protected $appends = ['total', 'count'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responsible_branch()
    {
        return $this->hasMany(Branch::class);
    }
    public function getTotalAttribute()
    {
        return collect($this->items)->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    // public function getTotalWithDiscountAttribute()
    // {
    //     return collect($this->items)->sum(function ($item) {
    //         return $item->quantity * $item->price;
    //     });
    // }

    public function getCountAttribute()
    {
        return $this->items->sum('quantity');
    }
}
