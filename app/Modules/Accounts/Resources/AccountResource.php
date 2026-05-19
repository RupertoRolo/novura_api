<?php

namespace App\Modules\Accounts\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'type'            => $this->type,
            'current_balance' => (float) $this->current_balance,
            'currency'        => $this->currency,
            'color'           => $this->color,
            'icon'            => $this->icon,
            'is_active'       => $this->is_active,
            'created_at'      => $this->created_at->toIso8601String(),
        ];
    }
}
