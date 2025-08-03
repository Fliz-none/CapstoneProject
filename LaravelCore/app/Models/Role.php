<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{


    protected $appends = ['code'];

    protected static function booted()
    {
    }

    // Overriding the method to include guard_name in unique check
    public static function create(array $attributes = [])
    {
        return static::query()->firstOrCreate([
            'name' => $attributes['name'],
            'guard_name' => $attributes['guard_name'],
        ]);
    }
    public function getCodeAttribute()
    {
        return 'R' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }
}
