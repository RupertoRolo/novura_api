<?php

namespace App\Modules\Movements\Repositories;

use App\Models\Movement;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class MovementRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Movement());
    }

    public function paginateForUser(int $userId, array $filters, int $perPage): LengthAwarePaginator
    {
        $query = Movement::where('user_id', $userId)
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

    public function balanceForAccount(int $accountId): float
    {
        return (float) Movement::where('financial_account_id', $accountId)
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as balance")
            ->value('balance') ?? 0;
    }
}
