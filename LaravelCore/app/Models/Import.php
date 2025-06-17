<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Import extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'imports';
    protected $appends = ['code', 'total', 'statusStr'];
    protected $fillable = [
        'user_id',
        'warehouse_id',
        'export_id',
        'supplier_id',
        'note',
        'created_at',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function export()
    {
        return $this->belongsTo(Warehouse::class, 'export_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function import_details()
    {
        return $this->hasMany(ImportDetail::class);
    }
    public function _user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
    public function _warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id')->withTrashed();
    }
    public function _export()
    {
        return $this->belongsTo(Export::class, 'export_id')->withTrashed();
    }
    public function _supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withTrashed();
    }

    public function checkLoss() {
        $loss = false;
        $this->import_details->each(function ($detail, $i) use (&$loss) {
            $stock = $detail->stock;
            if ($stock && $stock->export_details->count()) {
                $loss = true;
                return false;
            }
        });
        return $loss;
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '1':
                //  đang bán hoac da nhap kho
                $result = $this->checkLoss() ? __('messages.import.selling') : __('messages.import.imported');
                break;
            case '0':
                $result = __('messages.stock.waiting');
                break;
            default:
                $result = __('messages.unknown');
                break;
        }
        return $result;
    }

    public function getTotalAttribute()
    {
        return $this->import_details->sum(function ($import_detail) {
            return $import_detail->quantity * $import_detail->price;
        });
    }

    public function canRemove() {
        return !$this->checkLoss() & !$this->export_id;
    }

    public function getCodeAttribute()
    {
        return 'IM' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
