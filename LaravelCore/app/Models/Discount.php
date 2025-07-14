<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'discounts';
    protected $appends = ['code', 'typeStr'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }


    protected $fillable = [
        'name',
        'branch_id',
        'type',
        'apply_type',
        'value',
        'buy_quantity',
        'get_quantity',
        'min_quantity',
        'start_date',
        'end_date',
        'status'
    ];


    public function units()
    {
        return $this->belongsToMany(Unit::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getCodeAttribute()
    {
        return 'GG' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '0':
                $name = __('messages.inactive');
                break;
            case '1':
                $name = __('messages.active');
                break;
            default:
                $name = __('messages.unknown');
                break;
        }
        return $name;
    }

    public function getTypeStrAttribute()
    {
        switch ($this->type) {
            case '0':
                return "Discount $this->value%";
            case '1':
                return 'Discount ' . number_format($this->value) . ' VND';
            case '2':
                return "Buy $this->buy_quantity get $this->get_quantity";
            default:
                break;
        }
    }

    public function syncUnit(array $unitIds)
    {
        DB::table('discount_unit')->where('discount_id', $this->id)->delete();

        $data = array_map(function ($unitId) {
            return [
                'discount_id' => $this->id,
                'unit_id' => $unitId,
            ];
        }, $unitIds);

        DB::table('discount_unit')->insert($data);
    }
}
