<?php

namespace App\Modules\Accounts\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['sometimes', 'string', 'max:255'],
            'type'      => ['sometimes', Rule::in(['checking', 'savings', 'cash', 'credit_card', 'investment', 'other'])],
            'currency'  => ['sometimes', 'string', 'size:3'],
            'color'     => ['sometimes', 'nullable', 'string', 'max:20'],
            'icon'      => ['sometimes', 'nullable', 'string', 'max:50'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
