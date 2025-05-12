<?php

namespace App\Models;

use App\Models\QueueItem;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = [
        'code',
        'customer_name',
        'no_wa',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(QueueItem::class);
    }

    protected static function booted()
    {
        static::creating(function ($queue) {
            $queue->code = 'Q-' . strtoupper(uniqid());
        });
    }

    public function getTotalPriceAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}
