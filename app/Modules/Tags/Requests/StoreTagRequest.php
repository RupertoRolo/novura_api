<?php

namespace App\Modules\Tags\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:100'],
            'color' => ['sometimes', 'nullable', 'string', 'max:20'],
        ];
    }
}
