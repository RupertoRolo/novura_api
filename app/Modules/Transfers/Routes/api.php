<?php

use App\Modules\Transfers\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

Route::apiResource('transfers', TransferController::class)->only(['index', 'store', 'show', 'destroy']);

