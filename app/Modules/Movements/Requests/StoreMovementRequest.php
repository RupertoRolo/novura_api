<?php

namespace App\Modules\Movements\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'financial_account_id' => ['required', 'integer', Rule::exists('financial_accounts', 'id')->where('user_id', $this->user()->id)],
            'category_id'          => ['sometimes', 'nullable', 'integer', 'exists:categories,id'],
            'subcategory_id'       => ['sometimes', 'nullable', 'integer', 'exists:subcategories,id'],
            'type'                 => ['required', Rule::in(['income', 'expense'])],
            'amount'               => ['required', 'numeric', 'min:0.01'],
            'description'          => ['sometimes', 'nullable', 'string', 'max:500'],
            'notes'                => ['sometimes', 'nullable', 'string', 'max:1000'],
            'transaction_date'     => ['required', 'date'],
            'tag_ids'              => ['sometimes', 'array'],
            'tag_ids.*'            => ['integer', 'exists:tags,id'],
        ];
    }
}
