<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoviePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->type === 'A';
    }

    public function viewOnShow(User $user): bool
    {
        return true; // Allow all users to view movies currently on show
    }

    public function view(User $user, Movie $movie): bool
    {
        // Implement your logic here to determine if the user can view this particular movie
        // For example, you might check if the user has purchased a ticket for this movie
        return true; // Example: Always allow viewing for now
    }

    public function create(User $user): bool
    {
        return $user->type === 'A';
    }

    public function update(User $user, Movie $movie): bool
    {
        return $user->type === 'A';
    }

    public function delete(User $user, Movie $movie): bool
    {
        return $user->type === 'A';
    }

    public function viewScreenings(User $user, Movie $movie): bool
    {
        // Example logic: Allow viewing screenings if the movie is on show
        return $movie->isOnShow();
    }
}
