<?php

namespace App\Modules\Movements\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'      => ['sometimes', 'nullable', 'integer', 'exists:categories,id'],
            'subcategory_id'   => ['sometimes', 'nullable', 'integer', 'exists:subcategories,id'],
            'type'             => ['sometimes', Rule::in(['income', 'expense'])],
            'amount'           => ['sometimes', 'numeric', 'min:0.01'],
            'description'      => ['sometimes', 'nullable', 'string', 'max:500'],
            'notes'            => ['sometimes', 'nullable', 'string', 'max:1000'],
            'transaction_date' => ['sometimes', 'date'],
            'tag_ids'          => ['sometimes', 'array'],
            'tag_ids.*'        => ['integer', 'exists:tags,id'],
        ];
    }
}
