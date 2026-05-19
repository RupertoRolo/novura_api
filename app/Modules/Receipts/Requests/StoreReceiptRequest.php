<?php

namespace App\Modules\Receipts\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file'        => [
                'required',
                'file',
                'max:5120',
                'mimes:jpg,jpeg,png,pdf,webp',
            ],
            'movement_id' => [
                'sometimes',
                'nullable',
                'integer',
                Rule::exists('movements', 'id')->where('user_id', $this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.max'   => 'The file must not exceed 5MB.',
            'file.mimes' => 'Allowed formats: jpg, jpeg, png, pdf, webp.',
        ];
    }
}
