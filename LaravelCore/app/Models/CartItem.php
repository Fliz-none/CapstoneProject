<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['cart_id', 'unit_id', 'stock_id', 'quantity', 'price', 'allocated_to_warehouse_id'];
    protected $appends = ['sub_total'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function allocated_to_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'allocated_to_warehouse_id');
    }
    public function getSubTotalAttribute()
    {
        return number_format($this->quantity * $this->price);
    }
}
