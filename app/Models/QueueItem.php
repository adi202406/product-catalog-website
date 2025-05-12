<?php
namespace App\Models;

use App\Models\Queue;
use Illuminate\Database\Eloquent\Model;

class QueueItem extends Model
{
    protected $fillable = [
        'queue_id',
        'item_name',
        'quantity',
        'price',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
