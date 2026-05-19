<?php

namespace App\Modules\Accounts\Services;

use App\Models\FinancialAccount;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountService
{
    public function list(User $user, int $perPage = 20): LengthAwarePaginator
    {
        return FinancialAccount::where('user_id', $user->id)
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function store(User $user, array $data): FinancialAccount
    {
        return FinancialAccount::create([
            'user_id'         => $user->id,
            'name'            => $data['name'],
            'type'            => $data['type'],
            'current_balance' => $data['initial_balance'] ?? 0,
            'currency'        => $data['currency'] ?? 'COP',
            'color'           => $data['color'] ?? null,
            'icon'            => $data['icon'] ?? null,
        ]);
    }

    public function update(FinancialAccount $account, array $data): FinancialAccount
    {
        $account->update($data);

        return $account->fresh();
    }

    public function destroy(FinancialAccount $account): void
    {
        $account->delete();
    }
}
