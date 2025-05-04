<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'details';
    protected $appends = ['realPrice', 'total'];
    protected $fillable = [
        'order_id',
        'stock_id',
        'unit_id',
        'quantity',
        'price',
        'discount',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function info()
    {
        return $this->hasOne(Info::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function export_detail()
    {
        return $this->hasOne(ExportDetail::class);
    }

    public function _order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withTrashed();
    }

    public function _stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id')->withTrashed();
    }

    public function _info()
    {
        return $this->hasOne(Info::class, 'detail_id')->withTrashed();
    }

    public function _unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id')->withTrashed();
    }

    public function _export_detail()
    {
        return $this->hasOne(ExportDetail::class, 'export_detail_id')->withTrashed();
    }

    public function getTotalAttribute() //Tính tổng đã giảm
    {
        return $this->realPrice * $this->quantity;
    }

    public function getOriginalTotalAttribute() //Tính tổng chưa giảm
    {
        return $this->price * $this->quantity;
    }

    public function getRealPriceAttribute() //Tính giá thực tế
    {
        $price = $this->price;
        switch (true) {
            case $this->discount > 0 && $this->discount <= 100:
                $result = $price - $this->discount * $price / 100;
                break;
            case $this->discount > 100 || $this->discount < 0:
                $result = $price - $this->discount;
                break;
            default:
                $result = $price;
                break;
        }
        return $result;
    }
}
