<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExportDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'export_details';

    protected $fillable = [
        'stock_id',
        'export_id',
        'detail_id',
        'unit_id',
        'quantity',
        'note',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function export()
    {
        return $this->belongsTo(Export::class);
    }

    public function detail()
    {
        return $this->belongsTo(Detail::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function _stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id')->withTrashed();
    }

    public function _export()
    {
        return $this->belongsTo(Export::class, 'export_id')->withTrashed();
    }

    public function _detail()
    {
        return $this->belongsTo(Detail::class, 'detail_id')->withTrashed();
    }

    public function _unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id')->withTrashed();
    }

    public function import_detail() {
        return $this->hasOne(ImportDetail::class);
    }

    public function canRemove() {
        $has_order = $this->detail_id;
        $check_loss = $this->import_detail->stock->export_details->count();
        return !$has_order && !$check_loss;
    }
}
