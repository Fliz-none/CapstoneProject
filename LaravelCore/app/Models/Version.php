<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    protected $table = 'versions';

    protected $appends = ['code'];

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function _user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getCodeAttribute()
    {
        return 'VER' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
