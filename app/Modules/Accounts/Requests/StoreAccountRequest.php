<?php

namespace App\Modules\Accounts\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'type'            => ['required', Rule::in(['checking', 'savings', 'cash', 'credit_card', 'investment', 'other'])],
            'initial_balance' => ['sometimes', 'numeric', 'min:0'],
            'currency'        => ['sometimes', 'string', 'size:3'],
            'color'           => ['sometimes', 'nullable', 'string', 'max:20'],
            'icon'            => ['sometimes', 'nullable', 'string', 'max:50'],
        ];
    }
}
