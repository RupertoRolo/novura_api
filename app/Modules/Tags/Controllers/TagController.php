<?php

namespace App\Modules\Tags\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tags\Requests\StoreTagRequest;
use App\Modules\Tags\Resources\TagResource;
use App\Modules\Tags\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(private readonly TagService $service) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('per_page', 20), 100);
        $tags    = $this->service->list($request->user(), $perPage);

        return $this->success(TagResource::collection($tags)->response()->getData(true));
    }

    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = $this->service->store($request->user(), $request->validated());

        return $this->created(new TagResource($tag));
    }
}
