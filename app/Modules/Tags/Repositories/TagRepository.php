<?php

namespace App\Modules\Tags\Repositories;

use App\Models\Tag;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TagRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Tag());
    }

    public function paginateForUser(int $userId, int $perPage): LengthAwarePaginator
    {
        return Tag::where(function ($q) use ($userId) {
            $q->whereNull('user_id')->orWhere('user_id', $userId);
        })
        ->orderBy('name')
        ->paginate($perPage);
    }
}
