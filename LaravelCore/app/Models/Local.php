<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Local extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'locals';

    protected $fillable = [
        'city',
        'district',
    ];

    public function customers()
    {
        return $this->hasMany(User::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
}
