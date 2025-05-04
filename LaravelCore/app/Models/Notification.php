<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'notifications';
    protected $fillable = [
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function _users()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }
}
