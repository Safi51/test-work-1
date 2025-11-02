<?php

namespace App\Http\Controllers\BalanceControllers;

use App\Models\User;
use Illuminate\Http\Request;

class BalanceController
{
    public function __invoke(User $user, Request $request)
    {
        $balance = $user->balance;

        return $balance ?? response()->json([
            'status' => 200,
            'message' => 'dont have balance',
        ]);
    }
}
