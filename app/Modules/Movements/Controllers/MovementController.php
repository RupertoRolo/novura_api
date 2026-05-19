<?php

namespace App\Modules\Movements\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Modules\Movements\Requests\StoreMovementRequest;
use App\Modules\Movements\Requests\UpdateMovementRequest;
use App\Modules\Movements\Resources\MovementResource;
use App\Modules\Movements\Services\MovementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function __construct(private readonly MovementService $service) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('per_page', 20), 100);
        $filters = $request->only(['account_id', 'type', 'from', 'to']);

        $movements = $this->service->list($request->user(), $filters, $perPage);

        return $this->success(MovementResource::collection($movements)->response()->getData(true));
    }

    public function store(StoreMovementRequest $request): JsonResponse
    {
        $movement = $this->service->store($request->user(), $request->validated());

        return $this->created(new MovementResource($movement));
    }

    public function show(Request $request, Movement $movement): JsonResponse
    {
        $this->authorize('view', $movement);

        return $this->success(new MovementResource($movement->load(['category', 'subcategory', 'tags'])));
    }

    public function update(UpdateMovementRequest $request, Movement $movement): JsonResponse
    {
        $this->authorize('update', $movement);

        $movement = $this->service->update($movement, $request->validated());

        return $this->success(new MovementResource($movement));
    }

    public function destroy(Request $request, Movement $movement): JsonResponse
    {
        $this->authorize('delete', $movement);

        $this->service->destroy($movement);

        return $this->noContent();
    }
}
