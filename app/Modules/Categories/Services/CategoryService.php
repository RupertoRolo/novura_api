<?php

namespace App\Modules\Categories\Services;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function list(User $user, int $perPage = 20): LengthAwarePaginator
    {
        return Category::where(function ($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user->id);
        })
        ->with('subcategories')
        ->orderBy('name')
        ->paginate($perPage);
    }

    public function store(User $user, array $data): Category
    {
        $category = Category::create([
            'user_id' => $user->id,
            'name'    => $data['name'],
            'type'    => $data['type'],
            'icon'    => $data['icon'] ?? null,
            'color'   => $data['color'] ?? null,
        ]);

        return $category->load('subcategories');
    }

    public function subcategories(Category $category): Collection
    {
        return $category->subcategories()->get();
    }
}
