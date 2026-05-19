<?php

namespace App\Modules\Receipts\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ReceiptResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'movement_id'   => $this->movement_id,
            'original_name' => $this->original_name,
            'mime_type'     => $this->mime_type,
            'file_size'     => $this->file_size,
            'url'           => Storage::disk('receipts')->url($this->file_path),
            'ocr_data'      => $this->ocr_data,
            'status'        => $this->status,
            'created_at'    => $this->created_at->toIso8601String(),
        ];
    }
}
