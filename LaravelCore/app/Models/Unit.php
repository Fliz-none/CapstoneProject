<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Unit extends Model
{
    use HasFactory, SoftDeletes;
    protected $appends = ['bestDiscount', 'sum_stock'];
    protected $fillable = [
        'term',
        'variable_id',
        'rate',
        'barcode',
        'price'
    ];

    public function variable()
    {
        return $this->belongsTo(Variable::class, 'variable_id');
    }

    public function _variable()
    {
        return $this->belongsTo(Variable::class, 'variable_id')->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function import_details()
    {
        return $this->hasMany(ImportDetail::class);
    }

    public function export_details()
    {
        return $this->hasMany(ExportDetail::class);
    }

    public function getSumStockAttribute()
    {
        return $this->import_details->sum(function ($import_detail) {
            return (optional($import_detail->stock)->quantity ?? 0) / $this->rate;
        });
    }

    public function discounts()
    {
        $today = now()->toDateString();

        return $this->belongsToMany(Discount::class)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today);
    }


    public function getBestDiscountAttribute()
    {
        $discounts = $this->discounts()
            ->where('branch_id', Auth::user()->main_branch)
            ->where('status', 1)
            ->get();
        if ($discounts->isEmpty()) {
            return null;
        }

        $result = $discounts->first();

        if (count($discounts) > 1) {
            foreach ($discounts as $discount) {
                switch ($result->type) {
                    case 2: // Mua X tặng Y
                        if ($discount->type === 2 && $result->get_quantity && $discount->get_quantity) {
                            $old = $result->buy_quantity / $result->get_quantity;
                            $new = $discount->buy_quantity / $discount->get_quantity;

                            if ($new < $old) {
                                $result = $discount;
                            }
                        }
                        break;
                    default:
                        if ($discount->type == 2) {
                            $result = $discount;
                        } else {
                            $price = $this->price;
                            $old = $price - ($result->type === 0 ? $price * ($result->value / 100) : $result->value);
                            $new = $price - ($discount->type === 0 ? $price * ($discount->value / 100) : $discount->value);

                            if ($new < $old) {
                                $result = $discount;
                            }
                        }
                        break;
                }
            }
        }
        return $result;
    }

    public function _discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_unit');
    }
}
