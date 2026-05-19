<?php

namespace App\Modules\Alerts\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Modules\Alerts\Resources\AlertResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlertController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('per_page', 20), 100);

        $alerts = Alert::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return $this->success(AlertResource::collection($alerts)->response()->getData(true));
    }

    public function markRead(Request $request, Alert $alert): JsonResponse
    {
        abort_if($alert->user_id !== $request->user()->id, 403);

        $alert->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return $this->success(new AlertResource($alert));
    }
}
