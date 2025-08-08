<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'expenses';
    protected $appends = ['code', 'paymentStr', 'avatarUrl', 'statusStr'];
    protected $fillable = [
        'user_id',
        'branch_id',
        'payment',
        'amount',
        'note',
        'status',
        'group',
        'image'
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function getPaymentStrAttribute()
    {
        switch (true) {
            case $this->payment == '0':
                $result = __('messages.datatable.other');
                break;
            case $this->payment == '1':
                $result = __('messages.datatable.cash');
                break;
            default:
                $result = __('messages.datatable.transfer');
                break;
        }
        return $result;
    }

    public function getCodeAttribute()
    {
        return 'EXP' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getAvatarUrlAttribute()
    {
        $path = 'public/expense/' . $this->image;
        if ($this->image && Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE') . '/expense/' . $this->image);
        } else {
            $image = asset('admin/images/placeholder_key.png');
        }
        return $image;
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '1':
                // Da duyet
                $result = 'Approved';
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
}
