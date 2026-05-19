<?php

namespace App\Modules\Transfers\Resources;

use App\Modules\Accounts\Resources\AccountResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'amount'              => (float) $this->amount,
            'description'         => $this->description,
            'transaction_date'    => $this->transaction_date->toDateString(),
            'source_account'      => new AccountResource($this->whenLoaded('sourceAccount')),
            'destination_account' => new AccountResource($this->whenLoaded('destinationAccount')),
            'created_at'          => $this->created_at->toIso8601String(),
        ];
    }
}
