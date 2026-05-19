<?php

namespace App\Modules\Categories\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Modules\Categories\Requests\StoreCategoryRequest;
use App\Modules\Categories\Resources\CategoryResource;
use App\Modules\Categories\Resources\SubcategoryResource;
use App\Modules\Categories\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $service) {}

    public function index(Request $request): JsonResponse
    {
        $perPage    = min((int) $request->query('per_page', 20), 100);
        $categories = $this->service->list($request->user(), $perPage);

        return $this->success(CategoryResource::collection($categories)->response()->getData(true));
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->store($request->user(), $request->validated());

        return $this->created(new CategoryResource($category));
    }

    public function subcategories(Request $request, Category $category): JsonResponse
    {
        $items = $this->service->subcategories($category);

        return $this->success(SubcategoryResource::collection($items));
    }
}
