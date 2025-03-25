<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'promo_price',
        'is_available',
        'product_id',
    ];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'type_id');
    }
}
