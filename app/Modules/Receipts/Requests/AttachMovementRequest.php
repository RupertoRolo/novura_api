<?php

namespace App\Modules\Receipts\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movement_id' => [
                'required',
                'integer',
                Rule::exists('movements', 'id')->where('user_id', $this->user()->id),
            ],
        ];
    }
}
