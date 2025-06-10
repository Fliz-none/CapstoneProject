<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'stocks';
    protected $appends = ['code'];
    protected $fillable = [
        'import_detail_id',
        'quantity',
        'lot',
        'expired',
    ];

    public function import_detail()
    {
        return $this->belongsTo(ImportDetail::class);
    }

    public function _import_detail()
    {
        return $this->belongsTo(ImportDetail::class, 'import_detail_id')->withTrashed();
    }

    public function export_details()
    {
        return $this->hasMany(ExportDetail::class);
    }

    public function order_details()
    {
        return $this->hasMany(Detail::class);
    }

    public function productName(){
        $variable = $this->_import_detail->_variable;
        $v_name = ' - ' . $variable->name;
        $str = $variable->_product->deleted_at ? '<span class="text-danger">' . $variable->_product->name . '</span>' : $variable->_product->name;
        $str .= $variable->deleted_at ? '<span class="text-danger">' . $v_name . '</span>' : $v_name;
        return $str;
    }

    public function getCodeAttribute()
    {
        return 'STO' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function canRemove()
    {
        $has_export = $this->export_details->count();
        $internal_import = $this->import_detail->_import->export_id;
        return !$has_export && !$internal_import ? true : false;
    }
}
