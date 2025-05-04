<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $appends = ['code', 'ip'];

    protected $fillable = [
        'user_id',
        'action',
        'type',
        'object',
        'geolocation',
        'agent',
        'platform',
        'device',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function _branch()
    {
        return $this->belongsTo(Branch::class)->withTrashed();
    }

    public function _user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getCodeAttribute()
    {
        return 'LOG' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getPosition()
    {
        $geolocation = json_decode($this->geolocation, true);
        if (is_array($geolocation) && isset($geolocation['city'], $geolocation['country'])) {
            return $geolocation['city'] . ', ' . $geolocation['country'];
        }
        return 'Unknown, Unknown';
    }

    public function getIpAttribute()
    {
        $geolocation = json_decode($this->geolocation, true);
        if (is_array($geolocation) && isset($geolocation['ip'])) {
            return $geolocation['ip'];
        }
        return 'Unknown';
    }
}
