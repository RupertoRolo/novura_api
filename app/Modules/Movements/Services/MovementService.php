<?php

namespace App\Modules\Movements\Services;

use App\Models\FinancialAccount;
use App\Models\Movement;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MovementService
{
    public function list(User $user, array $filters, int $perPage = 20): LengthAwarePaginator
    {
        $query = Movement::where('user_id', $user->id)
            ->with(['category', 'subcategory', 'tags']);

        if (!empty($filters['account_id'])) {
            $query->where('financial_account_id', $filters['account_id']);
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['from'])) {
            $query->whereDate('transaction_date', '>=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $query->whereDate('transaction_date', '<=', $filters['to']);
        }

        return $query->orderByDesc('transaction_date')->orderByDesc('id')->paginate($perPage);
    }

    public function store(User $user, array $data): Movement
    {
        return DB::transaction(function () use ($user, $data) {
            $movement = Movement::create([
                'user_id'              => $user->id,
                'financial_account_id' => $data['financial_account_id'],
                'category_id'          => $data['category_id'] ?? null,
                'subcategory_id'       => $data['subcategory_id'] ?? null,
                'type'                 => $data['type'],
                'amount'               => $data['amount'],
                'description'          => $data['description'] ?? null,
                'notes'                => $data['notes'] ?? null,
                'transaction_date'     => $data['transaction_date'],
            ]);

            if (!empty($data['tag_ids'])) {
                $movement->tags()->sync($data['tag_ids']);
            }

            $this->updateBalance($movement->financial_account_id);

            return $movement->load(['category', 'subcategory', 'tags']);
        });
    }

    public function update(Movement $movement, array $data): Movement
    {
        return DB::transaction(function () use ($movement, $data) {
            $oldAccountId = $movement->financial_account_id;

            $movement->update($data);

            if (array_key_exists('tag_ids', $data)) {
                $movement->tags()->sync($data['tag_ids'] ?? []);
            }

            $this->updateBalance($movement->financial_account_id);

            if (isset($data['financial_account_id']) && (int) $data['financial_account_id'] !== $oldAccountId) {
                $this->updateBalance($oldAccountId);
            }

            return $movement->load(['category', 'subcategory', 'tags']);
        });
    }

    public function destroy(Movement $movement): void
    {
        DB::transaction(function () use ($movement) {
            $accountId = $movement->financial_account_id;
            $movement->delete();
            $this->updateBalance($accountId);
        });
    }

    private function updateBalance(int $accountId): void
    {
        $account = FinancialAccount::find($accountId);

        $movementsTotal = Movement::where('financial_account_id', $accountId)
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as total")
            ->value('total') ?? 0;

        $account->update(['current_balance' => $account->initial_balance + $movementsTotal]);
    }
}
