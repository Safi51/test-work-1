<?php

namespace App\Http\Requests\BalanceRequests;

use Illuminate\Foundation\Http\FormRequest;

class TransferStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_user_id' => 'required|exists:users,id',
            'to_user_id'   => 'required|exists:users,id',
            'amount'       => 'required|numeric',
            'comment'      => 'nullable|string',
        ];

    }
}
