<?php

namespace App\Modules\Movements\Policies;

use App\Models\Movement;
use App\Models\User;

class MovementPolicy
{
    public function view(User $user, Movement $movement): bool
    {
        return $user->id === $movement->user_id;
    }

    public function update(User $user, Movement $movement): bool
    {
        return $user->id === $movement->user_id;
    }

    public function delete(User $user, Movement $movement): bool
    {
        return $user->id === $movement->user_id;
    }
}
