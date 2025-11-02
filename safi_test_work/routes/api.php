<?php

use App\Http\Controllers\BalanceControllers\TransferController;
use App\Http\Controllers\BalanceControllers\WithdrawController;
use App\Http\Controllers\BalanceControllers\DepositController;
use App\Http\Controllers\BalanceControllers\BalanceController;
use Illuminate\Support\Facades\Route;

Route::post('deposit',DepositController::class);
Route::post('withdraw',WithdrawController::class);
Route::post('transfer', TransferController::class);
Route::get('balance/{user}',BalanceController::class);
