<?php

namespace App\Services;

use App\Helpers\Constants\TransactionType;
use App\Models\Balance;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class BalanceService
{
    public function deposit(array $data): void
    {
        try {
            $balance = Balance::whereUserId($data['user_id'])->first();

            if (!$balance) {
                Balance::create([
                    'user_id' => $data['user_id'],
                    'balance' => $data['amount'],
                ]);
            }else {
                $balance->update([
                    'balance' =>  $balance->balance + $data['amount'],
                ]);
            }

            Transaction::create([
                'to_user_id' => $data['user_id'],
                'amount'     => $data['amount'],
                'type'       => TransactionType::DEPOSIT,
                'comment'    => $data['comment'] ?? null,
            ]);

        }catch (\Exception $exception){
            Log::error('Deposit Exception', ['error' => $exception, 'request' => $data]);
        }
    }
}
