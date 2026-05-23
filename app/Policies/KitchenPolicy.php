<?php

namespace App\Policies;

use App\Models\Kitchen;
use App\Models\User;

class KitchenPolicy
{
    public function viewAny(User $user)
    {
        return (bool) ($user->is_admin ?? false);
    }

    public function view(User $user, Kitchen $kitchen)
    {
        return (bool) ($user->is_admin ?? false);
    }

    public function create(User $user)
    {
        return (bool) ($user->is_admin ?? false);
    }

    public function update(User $user, Kitchen $kitchen)
    {
        return (bool) ($user->is_admin ?? false);
    }

    public function delete(User $user, Kitchen $kitchen)
    {
        return (bool) ($user->is_admin ?? false);
    }
}
