<?php

namespace App\Http\Controllers\BalanceControllers;

use App\Http\Requests\BalanceRequests\DepositStoreRequest;
use App\Services\BalanceService;

class DepositController
{
    public function __invoke(DepositStoreRequest $request)
    {
        $service = new BalanceService();

        $service->deposit($request->validated());

        return request()->json([
            'status'  => 200,
            'message' => 'success'
        ]);
    }
}
