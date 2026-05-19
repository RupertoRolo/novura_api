<?php

namespace App\Modules\Transfers\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Modules\Transfers\Requests\StoreTransferRequest;
use App\Modules\Transfers\Resources\TransferResource;
use App\Modules\Transfers\Services\TransferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function __construct(private readonly TransferService $service) {}

    public function index(Request $request): JsonResponse
    {
        $perPage   = min((int) $request->query('per_page', 20), 100);
        $transfers = $this->service->list($request->user(), $perPage);

        return $this->success(TransferResource::collection($transfers)->response()->getData(true));
    }

    public function store(StoreTransferRequest $request): JsonResponse
    {
        $transfer = $this->service->store($request->user(), $request->validated());

        return $this->created(new TransferResource($transfer));
    }

    public function show(Request $request, Transfer $transfer): JsonResponse
    {
        abort_if($transfer->user_id !== $request->user()->id, 403);

        return $this->success(new TransferResource($transfer->load(['sourceAccount', 'destinationAccount'])));
    }

    public function destroy(Request $request, Transfer $transfer): JsonResponse
    {
        abort_if($transfer->user_id !== $request->user()->id, 403);

        $this->service->destroy($transfer);

        return $this->noContent();
    }
}
