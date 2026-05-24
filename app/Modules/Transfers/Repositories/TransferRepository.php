<?php

namespace App\Modules\Transfers\Repositories;

use App\Models\Transfer;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TransferRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Transfer());
    }

    public function paginateForUser(int $userId, int $perPage): LengthAwarePaginator
    {
        return Transfer::where('user_id', $userId)
            ->with(['sourceAccount', 'destinationAccount'])
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function sumOutgoing(int $accountId): float
    {
        return (float) Transfer::where('source_account_id', $accountId)->sum('amount');
    }

    public function sumIncoming(int $accountId): float
    {
        return (float) Transfer::where('destination_account_id', $accountId)->sum('amount');
    }
}
