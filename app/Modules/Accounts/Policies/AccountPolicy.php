<?php

namespace App\Modules\Accounts\Policies;

use App\Models\FinancialAccount;
use App\Models\User;

class AccountPolicy
{
    public function view(User $user, FinancialAccount $account): bool
    {
        return $user->id === $account->user_id;
    }

    public function update(User $user, FinancialAccount $account): bool
    {
        return $user->id === $account->user_id;
    }

    public function delete(User $user, FinancialAccount $account): bool
    {
        return $user->id === $account->user_id;
    }
}
