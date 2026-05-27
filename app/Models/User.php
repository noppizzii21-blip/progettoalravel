<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function venues(): HasMany
    {
        return $this->hasMany(Venue::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
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
        return $this->hasMany(Approval::class, 'approver_id');
    }

    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }

    public function isVenueOwner(): bool
    {
        return $this->role === 'venue_owner';
    }

    public function isApprover(): bool
    {
        return $this->role === 'approver';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
