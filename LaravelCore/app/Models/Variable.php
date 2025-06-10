<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Variable extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'variables';
    protected $appends = ['statusStr', 'fullName'];

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'stock_limit',
        'status',
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function _units()
    {
        return $this->hasMany(Unit::class, 'variable_id')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function _product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function import_details()
    {
        return $this->hasMany(ImportDetail::class);
    }

    public function getFullNameAttribute()
    {
        $product_name = $this->_product->sku ? $this->_product->sku . ' - ' . $this->_product->name : $this->_product->name;
        $variable_name = $this->name ? ' - ' . $this->name : '';
        $str = $this->_product->deleted_at ? '<span class="text-danger">' . $product_name . '</span>' : $product_name;
        $str .= $this->deleted_at ? '<span class="text-danger">' . $variable_name . '</span>' : $variable_name;
        return $str;
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '1':
                $name = 'Active';
                break;

            default:
                $name = 'Inactive';
                break;
        }
        return $name;
    }

    public function convertUnit($quantity = null)
    {
        // Lấy tất cả các đơn vị tính cho sản phẩm hiện tại, sắp xếp theo rate từ lớn đến nhỏ
        $units = $this->units->sortByDesc('rate');
        $result = [];

        if ($quantity > 0) {
            // Lặp qua từng đơn vị tính và thực hiện chia để lấy số lượng theo đơn vị đó
            foreach ($units as $unit) {
                if ($quantity >= $unit->rate) {
                    $count = intdiv($quantity, $unit->rate); // Chia lấy phần nguyên
                    $quantity = fmod($quantity, $unit->rate); // Lấy phần dư cho đơn vị nhỏ hơn

                    $result[] = "$count " . $unit->term;
                }
            }
            // Nếu còn lại số lượng nhỏ nhất, thêm vào kết quả
            if ($quantity > 0) {
                $smallestUnit = optional($units->last())->term;
                $result[] = rtrim(rtrim(number_format($quantity, 2, '.', ''), '0'), '.') . ' ' . $smallestUnit;
            }
            return implode(', ', $result); // Chuyển mảng kết quả thành chuỗi
        } else {
            return '0 ' . optional($units->last())->term;
        }
    }

    public function assignAttributes($attributes)
    {
        if (is_countable($attributes) && count($attributes)) {
            foreach ($attributes as $index => $attribute) {
                DB::table('attribute_variable')->insert([
                    'variable_id' => $this->id,
                    'attribute_id' => $attribute
                ]);
            }
        }
        return true;
    }

    public function isExhausted()
    {
        $stock_quantity = $this->sumStocks();
        $stock_limit = $this->stock_limit;
        return $stock_limit >= $stock_quantity;
    }

    public function sumStocks()
    {
        return $this->import_details->sum(function ($import_detail) {
            return $import_detail->stock->quantity;
        });
    }

    public function syncAttributes($attributes)
    {
        DB::table('attribute_variable')->where('variable_id', $this->id)->delete();
        $this->assignAttributes($attributes);
        return true;
    }

    public function getStocksToExport($quantity)
    {
        $stocks = [];
        while ($quantity > 0) {
            $oldestStock = Stock::where('quantity', '>', 0)
                ->whereHas('import_detail', function ($query) {
                    $query->where('variable_id', $this->id)
                        ->whereHas('import', function ($query) {
                            $query->whereIn('warehouse_id', Auth::user()->branch->warehouses->where('status', 1)->pluck('id'))
                                ->where('status', 1);
                        });
                })
                ->when(!empty($stocks), function ($query) use ($stocks) {
                    return $query->whereNotIn('id', $stocks);
                })
                ->orderByRaw('CASE
                            WHEN expired IS NOT NULL THEN expired
                            ELSE "9999-12-31"
                            END ASC, created_at ASC')
                ->first();


            if (!isset($oldestStock)) {
                return false;
            }

            $stocks[] = $oldestStock->id;

            if ($oldestStock->quantity >= $quantity) {
                $quantity = 0;
            } else {
                $quantity -= $oldestStock->quantity;
            }
        }

        return $stocks;
    }
}
