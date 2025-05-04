<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'import_details';
    protected $fillable = [
        'import_id',
        'export_detail_id',
        'variable_id',
        'unit_id',
        'quantity',
        'price',
    ];

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function import()
    {
        return $this->belongsTo(Import::class);
    }

    public function variable()
    {
        return $this->belongsTo(Variable::class);
    }

    public function export_detail()
    {
        return $this->belongsTo(ExportDetail::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function _import()
    {
        return $this->belongsTo(Import::class, 'import_id')->withTrashed();
    }

    public function _variable()
    {
        return $this->belongsTo(Variable::class, 'variable_id')->withTrashed();
    }

    public function _unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id')->withTrashed();
    }

    public function canRemove()
    {
        $has_export = $this->stock->export_details->count();
        $internal_import = $this->export_detail_id;
        return !$has_export && !$internal_import ? true : false;
    }
}