<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected static function booted()
    {
    }

    // Overriding the method to include company_id in unique check
    public static function create(array $attributes = [])
    {
        return static::query()->firstOrCreate([
            'name' => $attributes['name'],
            'guard_name' => $attributes['guard_name'],
        ]);
    }
}
