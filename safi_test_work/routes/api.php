<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BalanceControllers\DepositController;

Route::post('deposit',DepositController::class);
