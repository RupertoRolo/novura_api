<?php

namespace App\Modules\Tags\Services;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class TagService
{
    public function list(User $user, int $perPage = 20): LengthAwarePaginator
    {
        return Tag::where(function ($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user->id);
        })
        ->orderBy('name')
        ->paginate($perPage);
    }

    public function store(User $user, array $data): Tag
    {
        return Tag::create([
            'user_id' => $user->id,
            'name'    => $data['name'],
            'color'   => $data['color'] ?? null,
        ]);
    }
}
