<?php

namespace App\Models;

use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopInfo extends Model
{
    protected $table = 'shop_infos';
    protected $guarded = ['id'];

    public function socialMedia(): HasMany
    {
        return $this->hasMany(SocialMedia::class, 'shop_info_id');
    }
}
