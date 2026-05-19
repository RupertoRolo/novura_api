<?php

namespace App\Modules\Receipts\Services;

use App\Models\Receipt;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReceiptService
{
    public function list(User $user, int $perPage = 20): LengthAwarePaginator
    {
        return Receipt::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function store(User $user, UploadedFile $file, ?int $movementId): Receipt
    {
        $path = $this->storeFile($user->id, $file);

        return Receipt::create([
            'user_id'       => $user->id,
            'movement_id'   => $movementId,
            'file_path'     => $path,
            'original_name' => $this->sanitizeFilename($file->getClientOriginalName()),
            'mime_type'     => $file->getMimeType(),
            'file_size'     => $file->getSize(),
            'status'        => 'pending',
        ]);
    }

    public function attachMovement(Receipt $receipt, int $movementId): Receipt
    {
        $receipt->update(['movement_id' => $movementId]);

        return $receipt->fresh();
    }

    public function destroy(Receipt $receipt): void
    {
        Storage::disk('receipts')->delete($receipt->file_path);
        $receipt->delete();
    }

    private function storeFile(int $userId, UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename  = Str::uuid() . '.' . strtolower($extension);
        $folder    = "user_{$userId}";

        $file->storeAs($folder, $filename, 'receipts');

        return "{$folder}/{$filename}";
    }

    private function sanitizeFilename(string $name): string
    {
        // Strip anything that is not alphanumeric, dot, dash, or underscore
        $name = preg_replace('/[^\w.\-]/', '_', $name);

        return substr($name, 0, 255);
    }
}
