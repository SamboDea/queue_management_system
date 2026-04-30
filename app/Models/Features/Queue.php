<?php

namespace App\Models\Features;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Queue extends Model
{
    protected $fillable = [
        'ticket_number',
        'category',
        'status',
        'counter_id',
        'called_at',
        'served_at',
    ];
 
    protected $casts = [
        'called_at' => 'datetime',
        'served_at' => 'datetime',
    ];
 
    public function counter(): BelongsTo
    {
        return $this->belongsTo(Counter::class);
    }
 
    // Generate next ticket number per category
    public static function generateTicket(string $category): string
    {
        $last = self::whereDate('created_at', today())
            ->where('category', $category)
            ->orderByDesc('id')
            ->first();
 
        $number = $last
            ? (int) substr($last->ticket_number, 1) + 1
            : 1;
 
        return $category . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
