<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlacePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Place $place)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Place $place)
    {
        return true;
    }

    public function delete(User $user, Place $place)
    {
        return true;
    }
}
