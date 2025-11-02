<?php

namespace App\Http\Controllers\BalanceControllers;

use App\Http\Requests\BalanceRequests\BalanceStoreRequest;
use App\Services\BalanceService;

class WithdrawController
{
    public function __invoke(BalanceStoreRequest $request)
    {
        $service = new BalanceService();

        $service->withdraw($request->validated());

        return request()->json([
            'status'  => 200,
            'message' => 'success'
        ]);
    }
}
