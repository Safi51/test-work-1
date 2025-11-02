<?php

namespace App\Http\Requests\BalanceRequests;

use Illuminate\Foundation\Http\FormRequest;

class BalanceStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|numeric',
            'comment' => 'nullable|string',
        ];

    }
}
