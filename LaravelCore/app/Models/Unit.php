<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;
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
}
