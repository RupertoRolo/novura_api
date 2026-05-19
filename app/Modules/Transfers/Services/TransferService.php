<?php

namespace App\Modules\Transfers\Services;

use App\Models\FinancialAccount;
use App\Models\Movement;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TransferService
{
    public function list(User $user, int $perPage = 20): LengthAwarePaginator
    {
        return Transfer::where('user_id', $user->id)
            ->with(['sourceAccount', 'destinationAccount'])
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function store(User $user, array $data): Transfer
    {
        return DB::transaction(function () use ($user, $data) {
            $transfer = Transfer::create([
                'user_id'                => $user->id,
                'source_account_id'      => $data['source_account_id'],
                'destination_account_id' => $data['destination_account_id'],
                'amount'                 => $data['amount'],
                'description'            => $data['description'] ?? null,
                'transaction_date'       => $data['transaction_date'],
            ]);

            $this->recalculateBalance($data['source_account_id']);
            $this->recalculateBalance($data['destination_account_id']);

            return $transfer->load(['sourceAccount', 'destinationAccount']);
        });
    }

    public function destroy(Transfer $transfer): void
    {
        DB::transaction(function () use ($transfer) {
            $sourceId      = $transfer->source_account_id;
            $destinationId = $transfer->destination_account_id;

            $transfer->delete();

            $this->recalculateBalance($sourceId);
            $this->recalculateBalance($destinationId);
        });
    }

    private function recalculateBalance(int $accountId): void
    {
        $movementsBalance = Movement::where('financial_account_id', $accountId)
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as balance")
            ->value('balance') ?? 0;

        $transfersOut = Transfer::where('source_account_id', $accountId)->sum('amount');
        $transfersIn  = Transfer::where('destination_account_id', $accountId)->sum('amount');

        $balance = $movementsBalance - $transfersOut + $transfersIn;

        FinancialAccount::where('id', $accountId)->update(['current_balance' => $balance]);
    }
}
