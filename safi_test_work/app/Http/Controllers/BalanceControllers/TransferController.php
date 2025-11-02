<?php

namespace App\Http\Controllers\BalanceControllers;

use App\Http\Requests\BalanceRequests\BalanceStoreRequest;
use App\Http\Requests\BalanceRequests\TransferStoreRequest;
use App\Services\BalanceService;

class TransferController
{
    public function __invoke(TransferStoreRequest $request)
    {
        $service = new BalanceService();

        $service->transfer($request->validated());

        return request()->json([
            'status'  => 200,
            'message' => 'success'
        ]);
    }
}
