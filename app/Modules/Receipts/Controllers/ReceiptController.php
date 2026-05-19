<?php

namespace App\Modules\Receipts\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Modules\Receipts\Requests\AttachMovementRequest;
use App\Modules\Receipts\Requests\StoreReceiptRequest;
use App\Modules\Receipts\Resources\ReceiptResource;
use App\Modules\Receipts\Services\ReceiptService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function __construct(private readonly ReceiptService $service) {}

    public function index(Request $request): JsonResponse
    {
        $perPage  = min((int) $request->query('per_page', 20), 100);
        $receipts = $this->service->list($request->user(), $perPage);

        return $this->success(ReceiptResource::collection($receipts)->response()->getData(true));
    }

    public function store(StoreReceiptRequest $request): JsonResponse
    {
        $receipt = $this->service->store(
            $request->user(),
            $request->file('file'),
            $request->input('movement_id'),
        );

        return $this->created(new ReceiptResource($receipt));
    }

    public function show(Request $request, Receipt $receipt): JsonResponse
    {
        $this->authorize('view', $receipt);

        return $this->success(new ReceiptResource($receipt));
    }

    public function attachMovement(AttachMovementRequest $request, Receipt $receipt): JsonResponse
    {
        $this->authorize('update', $receipt);

        $receipt = $this->service->attachMovement($receipt, $request->movement_id);

        return $this->success(new ReceiptResource($receipt));
    }

    public function destroy(Request $request, Receipt $receipt): JsonResponse
    {
        $this->authorize('delete', $receipt);

        $this->service->destroy($receipt);

        return $this->noContent();
    }
}
