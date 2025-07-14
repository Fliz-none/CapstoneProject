<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'note'];
    protected $with = ['items.unit.variable.product:id,name,slug', 'items.unit.variable.product.catalogues:id,name,slug'];
    protected $appends = ['total', 'count'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
