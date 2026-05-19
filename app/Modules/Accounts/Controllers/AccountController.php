<?php

namespace App\Modules\Accounts\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FinancialAccount;
use App\Modules\Accounts\Requests\StoreAccountRequest;
use App\Modules\Accounts\Requests\UpdateAccountRequest;
use App\Modules\Accounts\Resources\AccountResource;
use App\Modules\Accounts\Services\AccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(private readonly AccountService $service) {}

    public function index(Request $request): JsonResponse
    {
        $perPage  = min((int) $request->query('per_page', 20), 100);
        $accounts = $this->service->list($request->user(), $perPage);

        return $this->success(AccountResource::collection($accounts)->response()->getData(true));
    }

    public function store(StoreAccountRequest $request): JsonResponse
    {
        $account = $this->service->store($request->user(), $request->validated());

        return $this->created(new AccountResource($account));
    }

    public function show(Request $request, FinancialAccount $account): JsonResponse
    {
        $this->authorize('view', $account);

        return $this->success(new AccountResource($account));
    }

    public function update(UpdateAccountRequest $request, FinancialAccount $account): JsonResponse
    {
        $this->authorize('update', $account);

        $account = $this->service->update($account, $request->validated());

        return $this->success(new AccountResource($account));
    }

    public function destroy(Request $request, FinancialAccount $account): JsonResponse
    {
        $this->authorize('delete', $account);

        $this->service->destroy($account);

        return $this->noContent();
    }
}
