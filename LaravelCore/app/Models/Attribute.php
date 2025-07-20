<?php

namespace App\Models;

use Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    
    protected $table = 'attributes';
    public $timestamps = false;
    protected $appends = ['code'];
    protected $fillable = [
        'key',
        'value',
    ];

    public function variables()
    {
        return $this->belongsToMany(Variable::class);
    }

    public function getCodeAttribute()
    {
        return 'ATTR' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
