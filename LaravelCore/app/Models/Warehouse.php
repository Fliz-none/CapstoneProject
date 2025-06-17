<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'warehouses';
    protected $appends = array('code', 'fullName', 'statusStr');
    protected $fillable = [
        'branch_id',
        'name',
        'address',
        'note',
        'status',
        'open_sale',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function _branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function imports()
    {
        return $this->hasMany(Import::class);
    }

    public function getCodeAttribute()
    {
        return 'WH' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getFullNameAttribute()
    {
        $str = '<span class="' . ($this->deleted_at ? 'text-danger' : 'text-primary') . '">' . $this->name . '</span>';
        return $str;
    }
    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '2':
                $name = __('messages.warehouses.on_sale');
                break;
            case '1':
                $name = __('messages.warehouses.internal');
                break;
            default:
                $name = __('messages.warehouses.lock');
                break;
        }
        return $name;
    }    

    public function canRemove()
    {
        foreach ($this->imports as $key => $import) {
            if ($import->stocks->where('quantity', '>', 0)->count()) {
                return false;
            }
        }
        return true;
    }
}
