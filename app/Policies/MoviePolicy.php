<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;

class MoviePolicy
{
    public function before(User $user): ?bool
    {
        return true;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }


    public function view(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->type === 'A';
    }

    public function update(User $user, Movie $movie): bool
    {
        $aux = $movie->user;
        return $user->type === 'A' ;
    }

    public function delete(User $user, Movie $movie): bool
    {
        $aux = $movie->user();
        return $user->type === 'A' ;
    }
}
