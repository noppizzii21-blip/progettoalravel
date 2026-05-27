<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Auth\Access\Response;

class VenuePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Venue $venue): bool
    {
        return $venue->status === 'approved'
            || $user->isApprover()
            || ($user->isVenueOwner() && $venue->user_id === $user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isVenueOwner();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Venue $venue): bool
    {
        return $user->isVenueOwner()
            && $venue->user_id === $user->id
            && $venue->status !== 'approved';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Venue $venue): bool
    {
        return $user->isVenueOwner() && $venue->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Venue $venue): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Venue $venue): bool
    {
        return false;
    }
}
