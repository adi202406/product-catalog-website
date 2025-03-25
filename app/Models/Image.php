<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url',
    ];
    public function types()
    {
        return $this->hasMany(Type::class, 'image_id');
    }
}
