<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketSale extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'quantity',
        'total_price',
        'stripe_payment_id',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
