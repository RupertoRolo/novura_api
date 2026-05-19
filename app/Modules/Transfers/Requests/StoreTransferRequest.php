<?php

namespace App\Modules\Transfers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_account_id'      => ['required', 'integer', Rule::exists('financial_accounts', 'id')->where('user_id', $this->user()->id)],
            'destination_account_id' => ['required', 'integer', Rule::exists('financial_accounts', 'id')->where('user_id', $this->user()->id)],
            'amount'                 => ['required', 'numeric', 'min:0.01'],
            'description'            => ['sometimes', 'nullable', 'string', 'max:500'],
            'transaction_date'       => ['required', 'date'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->source_account_id === $this->destination_account_id) {
                    $validator->errors()->add('destination_account_id', 'Source and destination accounts must be different.');
                }
            },
        ];
    }
}
