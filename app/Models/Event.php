<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'venue_id',
        'title',
        'description',
        'image',
        'city',
        'zone',
        'address',
        'date',
        'time',
        'min_age',
        'max_participants',
        'access_type',
        'presale_price',
        'presale_quantity',
        'status',
    ];

    protected $casts = [
        'date' => 'datetime',
        'time' => 'datetime:H:i',
        'presale_price' => 'decimal:2',
    ];

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function ticketSales(): HasMany
    {
        return $this->hasMany(TicketSale::class);
    }

    public function waitingLists(): HasMany
    {
        return $this->hasMany(WaitingList::class);
    }

    public function approvals(): HasMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeWithApprovedVenue(Builder $query): Builder
    {
        return $query->whereHas('venue', fn ($query) => $query->where('status', 'approved'));
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
