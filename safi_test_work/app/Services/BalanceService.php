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
        $this->incrementOrDecrement($data, TransactionType::DEPOSIT);
    }
    public function withdraw(array $data): void
    {
        $this->incrementOrDecrement($data, TransactionType::WITHDRAW);
    }
    public function transfer(array $data): void
    {
        try {
            $balancesQuery = Balance::whereIn('user_id', [
                $data['from_user_id'],
                $data['to_user_id'],
            ]);

            if ($balancesQuery->count() < 2) {
                abort('403', 'users dont have balance');
            }

            if ($balancesQuery->each(function ($balance) use ($data) {
                if ($balance->user_id === (int)$data['from_user_id']) {
                    $price = $balance->balance - $data['amount'];
                    if ($price < 0) {
                        abort('409', 'cannot balance more than 0');
                    }
                    $balance->update([
                        'balance' => $price,
                    ]);
                } else {
                    $balance->update([
                        'balance' => $balance->balance + $data['amount'],
                    ]);
                }
            }));
            Transaction::insert([
                [
                    'from_user_id' => $data['from_user_id'],
                    'to_user_id'   => $data['to_user_id'],
                    'amount'       => $data['amount'],
                    'type'         => TransactionType::TRANSFER_IN
                ],
                [
                    'from_user_id' => $data['to_user_id'],
                    'to_user_id'   => $data['from_user_id'],
                    'amount'       => $data['amount'],
                    'type'         => TransactionType::TRANSFER_OUT
                ]
            ]);
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }
    }
    public function incrementOrDecrement($data, $action): void
    {
        try {
            $balance = Balance::whereUserId($data['user_id'])->first();

            if (!$balance) {
                Balance::create([
                    'user_id' => $data['user_id'],
                    'balance' => $data['amount'],
                ]);
            }else {
                $isPositive = $action === TransactionType::WITHDRAW
                    ? ($balance->balance - $data['amount'] >= 0)
                    : true;

                if (!$isPositive) {
                    abort(409, 'Not enough balance');
                }

                $balance->update([
                    'balance' =>  $action !== TransactionType::WITHDRAW
                        ? $balance->balance + $data['amount']
                        : $balance->balance - $data['amount'],
                ]);
            }

            Transaction::create([
                'to_user_id' => $data['user_id'],
                'amount'     => $data['amount'],
                'type'       => $action,
                'comment'    => $data['comment'] ?? null,
            ]);
        }catch (\Exception $exception){
            Log::error('Deposit Exception', ['error' => $exception, 'request' => $data]);
        }
    }
}
