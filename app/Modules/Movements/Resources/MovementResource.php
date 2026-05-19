<?php

namespace App\Modules\Movements\Resources;

use App\Modules\Categories\Resources\CategoryResource;
use App\Modules\Categories\Resources\SubcategoryResource;
use App\Modules\Tags\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'financial_account_id' => $this->financial_account_id,
            'type'                 => $this->type,
            'amount'               => (float) $this->amount,
            'description'          => $this->description,
            'notes'                => $this->notes,
            'transaction_date'     => $this->transaction_date->toDateString(),
            'category'             => new CategoryResource($this->whenLoaded('category')),
            'subcategory'          => new SubcategoryResource($this->whenLoaded('subcategory')),
            'tags'                 => TagResource::collection($this->whenLoaded('tags')),
            'created_at'           => $this->created_at->toIso8601String(),
        ];
    }
}
