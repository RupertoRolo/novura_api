<?php

namespace App\Modules\Categories\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Category());
    }

    public function paginateForUser(int $userId, int $perPage): LengthAwarePaginator
    {
        return Category::where(function ($q) use ($userId) {
            $q->whereNull('user_id')->orWhere('user_id', $userId);
        })
        ->with('subcategories')
        ->orderBy('name')
        ->paginate($perPage);
    }
}
