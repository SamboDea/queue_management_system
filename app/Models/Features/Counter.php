<?php

namespace App\Models\Features;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Counter extends Model
{
    protected $fillable = [
        'name',
        'code',
        'status',
        'current_ticket',
    ];
 
    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class);
    }
 
    public function currentQueue()
    {
        return $this->hasOne(Queue::class)->where('status', 'serving');
    }
}
