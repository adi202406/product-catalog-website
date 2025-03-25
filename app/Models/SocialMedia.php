<?php

namespace App\Models;

use App\Models\ShopInfo;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $guarded = [
        'id',
    ];

    public function shopInfo()
    {
        return $this->belongsTo(ShopInfo::class, 'shop_info_id');
    }
}
