<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Dashboard\Services\DashboardService;
use App\Modules\Movements\Resources\MovementResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $service) {}

    public function index(Request $request): JsonResponse
    {
        $summary = $this->service->summary($request->user());

        $summary['recent_movements'] = MovementResource::collection($summary['recent_movements']);

        return $this->success($summary);
    }
}
