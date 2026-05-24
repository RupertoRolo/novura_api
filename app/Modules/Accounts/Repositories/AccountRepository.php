<?php

namespace App\Modules\Accounts\Repositories;

use App\Models\FinancialAccount;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new FinancialAccount());
    }

    public function paginateForUser(int $userId, int $perPage): LengthAwarePaginator
    {
        return FinancialAccount::where('user_id', $userId)
            ->orderBy('name')
            ->paginate($perPage);
    }
}
