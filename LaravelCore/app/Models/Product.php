<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $appends = ['code', 'galleryUrl', 'avatarUrl'];
    protected $fillable = [
        'sku',
        'name',
        'slug',
        'excerpt',
        'description',
        'specs',
        'keyword',
        'gallery',
        'sort',
        'allow_review',
        'status',
        'type',
        'price',
    ];


    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function catalogues()
    {
        return $this->belongsToMany(Catalogue::class);
    }

    public function variables()
    {
        return $this->hasMany(Variable::class);
    }

    public function createdAt()
    {
        return ($this->created_at) ? Carbon::parse($this->created_at)->format('H:i:s d/m/Y') : '';
    }

    public function createdDate()
    {
        return ($this->created_at) ? Carbon::parse($this->created_at)->format('Y-m-d') : '';
    }

    public function createdTime()
    {
        return ($this->created_at) ? Carbon::parse($this->created_at)->format('H:i:s') : '';
    }

    public function assignCatalogue($catalogue)
    {
        $result = DB::table('catalogue_product')->insert([
            'product_id' => $this->id,
            'catalogue_id' => $catalogue
        ]);
        return $result;
    }

    public function syncCatalogues($catalogues)
    {
        DB::table('catalogue_product')->where('product_id', $this->id)->delete();
        $array = $catalogues ?? [];
        foreach ($array as $index => $catalogue) {
            $this->assignCatalogue($catalogue);
        }
        return true;
    }

    public function getGalleryUrlAttribute()
    {
        if ($this->gallery) {
            $gallery = explode('|', $this->gallery);
            $images = [];
            foreach ($gallery as $key => $image) {
                if ($key) {
                    $path = 'public/' . $image;
                    if (Storage::exists($path)) {
                        $url = asset(env('FILE_STORAGE', '/storage') . '/' . $image);
                    } else {
                        $url = asset('admin/images/placeholder_key.png');
                    }
                    array_push($images, $url);
                }
            }
        } else {
            $images = [asset('admin/images/placeholder_key.png')];
        }
        return $images;
    }

    public function getAvatarUrlAttribute()
    {
        return $this->gallery ? $this->galleryUrl[0] : asset('admin/images/placeholder_key.png');
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '4':
                $name = __('messages.product.feature');
                break;
            case '3':
                $name = __('messages.product.online_and_offline');
                break;
            case '2':
                $name = __('messages.product.online');
                break;
            case '1':
                $name = __('messages.product.offline');
                break;
            case '0':
                $name = __('messages.product.locked');
                break;
            default:
                $name = __('messages.unknown');
                break;
        }
        return $name;
    }

    public function getCodeAttribute()
    {
        return 'PRO' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function displayPrice()
    {
        $currency = cache()->get('settings')['currency'] ?? 'VND';
        $prices = $this->variables->flatMap(function ($variable) {
            return $variable->units->pluck('price');
        })->filter(function ($price) {
            return $price !== null;
        });
        
        if ($prices->isEmpty()) {
            return '0 ' . $currency;
        }

        $min = $prices->min();
        $max = $prices->max();

        if ($min == $max) {
            return number_format($min) . ' ' . $currency;
        }

        return number_format($min) . ' ' . $currency . ' - ' . number_format($max) . ' ' . $currency;
    }

    public function relatedProducts()
    {
        $relatedProducts = [];
        foreach ($this->catalogues as $key => $catalogue) {
            foreach ($catalogue->products as $key => $product) {
                if ($product->id != $this->id && !in_array($product->id, array_column($relatedProducts, 'id'))) {
                    array_push($relatedProducts, $product);
                }
            }
        }
        return array_slice($relatedProducts, 0, 12);
    }
    public function catalogsName()
    {
        $catalogues = [];
        foreach ($this->catalogues->pluck('name', 'slug') as $slug => $name) {
            $text = '<a class"text-capitalize" href="' . route('product', ['catalogue' => $slug]) . '">' . $name . '</a>';
            array_push($catalogues, $text);
        }
        return implode(', ', $catalogues);
    }
}
