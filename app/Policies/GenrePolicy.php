<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Genre;
use Illuminate\Auth\Access\HandlesAuthorization;

class GenrePolicy
{
    use HandlesAuthorization;

    /**
     * Grant all abilities to administrators.
     */
    public function before(User $user): ?bool
    {
        if ($user->type === 'A') {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any genres.
     */
    public function viewAny(User $user): bool
    {
        return $user->type === 'A';
    }

    /**
     * Determine whether the user can view the genre.
     */
    public function view(User $user, Genre $genre): bool
    {
        return $user->type === 'A';
    }

    /**
     * Determine whether the user can create genres.
     */
    public function create(User $user): bool
    {
        return $user->type === 'A';
    }

    /**
     * Determine whether the user can update the genre.
     */
    public function update(User $user, Genre $genre): bool
    {
        return $user->type === 'A';
    }

    /**
     * Determine whether the user can delete the genre.
     */
    public function delete(User $user, Genre $genre): bool
    {
        return $user->type === 'A';
    }
}
