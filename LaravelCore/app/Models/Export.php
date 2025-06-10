<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Export extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'exports';
    protected $appends = ['code', 'statusStr'];
    protected $fillable = [
        'user_id',
        'receiver_id',
        'order_id',
        'to_warehouse_id',
        'note',
        'status',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function to_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function import()
    {
        return $this->hasOne(Import::class);
    }

    public function _order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withTrashed();
    }

    public function _user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function _receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->withTrashed();
    }

    public function _to_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id')->withTrashed();
    }

    public function export_details()
    {
        return $this->hasMany(ExportDetail::class);
    }

    public function getTotalAttribute()
    {
        return $this->export_details->sum(function ($export_detail) {
            return $export_detail->quantity * $export_detail->_stock->import_detail->price;
        });
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '1':
                $result = 'Done';
                break;
            case '0':
                $result = 'Waiting';
                break;
            default:
                $result = 'Unknown';
                break;
        }
        return $result;
    }

    public function canRemove()
    {
        $has_order = $this->order_id;
        $import_status = !$this->import->status;
        return !$has_order && !$import_status;
    }

    public function getCodeAttribute()
    {
        return 'EX' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
