<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Work extends Model
{
    use HasFactory;

    protected $table = 'works';
    protected $appends = ['code', 'image_checkin_url', 'image_checkout_url'];
    protected $fillable = [
        'user_id',
        'branch_id',
        'shift_name',
        'sign_checkin',
        'real_checkin',
        'image_checkin',
        'sign_checkout',
        'real_checkout',
        'image_checkout',
        'serve_time',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    public function getCodeAttribute()
    {
        return 'CHC' . str_pad($this->id, 6, "0", STR_PAD_LEFT);
    }

    public function getImageCheckinUrlAttribute()
    {
        $path = 'public/work/' . $this->image_checkin;
        if ($this->image_checkin && Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage') . '/work/' . $this->image_checkin);
        } else {
            $image = asset('admin/images/placeholder_key.png');
        }
        return $image;
    }

    public function getImageCheckoutUrlAttribute()
    {
        $path = 'public/work/' . $this->image_checkout;
        if ($this->image_checkout && Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE', '/storage') . '/work/' . $this->image_checkout);
        } else {
            $image = asset('admin/images/placeholder_key.png');
        }
        return $image;
    }

    public function gap_checkin()
    {
        if (is_null($this->sign_checkin) || is_null($this->real_checkin)) {
            return '';
        }
        $differenceInSeconds = Carbon::parse($this->sign_checkin)->diffInSeconds($this->real_checkin, false);

        $interval = CarbonInterval::seconds($differenceInSeconds)->cascade();

        if ($differenceInSeconds > 0) {
            $seconds = $differenceInSeconds < 60 ? $differenceInSeconds . ' sencond' : '';
            return '<br><span class="badge bg-danger">Late by ' . ($interval->hours ? $interval->hours . ' hour(s) ' : '') . ($interval->minutes ? $interval->minutes . ' minute(s)' : '') . $seconds . '</span>';
        } else {
            return '<br><span class="badge bg-primary">On time</span>';
        }
    }
    public function gap_checkout()
    {
        if (is_null($this->real_checkout) || is_null($this->sign_checkout)) {
            return '';
        }

        $differenceInSeconds = Carbon::parse($this->real_checkout)->diffInSeconds($this->sign_checkout, false);
        $interval = CarbonInterval::seconds($differenceInSeconds)->cascade();

        if ($differenceInSeconds > 0) {
            $seconds = $differenceInSeconds < 60 ? $differenceInSeconds . ' seconds' : '';
            return '<br><span class="badge bg-danger">Checked out early by ' .
                ($interval->hours ? $interval->hours . 'h ' : '') .
                ($interval->minutes ? $interval->minutes . 'm ' : '') .
                $seconds . '</span>';
        } else {
            return '<br><span class="badge bg-primary">On time</span>';
        }
    }
}
