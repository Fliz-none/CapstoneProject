<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'orders';
    protected $appends = ['code', 'statusStr', 'paid'];
    protected $fillable = [
        'branch_id',
        'customer_id',
        'dealer_id',
        'method',
        'total',
        'discount',
        'status',
        'note',
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function _customer()
    {
        return $this->belongsTo(User::class, 'customer_id')->withTrashed();
    }

    public function _dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id')->withTrashed();
    }


    public function _branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function exports()
    {
        return $this->hasMany(Export::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getSaveAmountAttribute() //Tính số tiền giảm
    {
        return $this->details->sum('originalTotal') - $this->total;
    }

    public function total() //Tính tổng đã giảm
    {
        $sumDetail = $this->details->sum('total');
        $orderDiscount = $this->discount;
        if ($this->discount > 100 || $this->discount == 0) {
            // Discount là số tiền
            $total = $sumDetail - $orderDiscount;
        } else {
            // Discount là phần trăm
            $total = $sumDetail - ($sumDetail * $orderDiscount / 100);
        }
        return $total;
    }

    public function sync_scores($amount) {
            $settings = cache()->get('settings_' . Auth::user()->company_id);
            $scores_rate_exchange = $settings['scores_rate_exchange'];
            optional($this->customer)->increment('scores', intdiv($amount, $scores_rate_exchange));
    }

    public function getPaidAttribute()
    {
        $paid = ($this->transactions->count()) ? $this->transactions->sum('amount') : 0;
        return $paid;
    }

    public function getCodeAttribute()
    {
        return 'DH' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '3':
                $result = ['color' => 'success', 'string' => 'Completed'];
                break;
            case '2':
                $result = ['color' => 'info', 'string' => 'Processing'];
                break;
            case '1':
                $result = ['color' => 'primary', 'string' => 'Queued'];
                break;
            case '0':
                $result = ['color' => 'danger', 'string' => 'Cancelled'];
                break;
            default:
                $result = ['color' => 'secondary', 'string' => 'Unknown'];
                break;
        }
        return $result;
    }
}
