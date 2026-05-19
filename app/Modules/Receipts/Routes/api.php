<?php

use App\Modules\Receipts\Controllers\ReceiptController;
use Illuminate\Support\Facades\Route;

Route::get('receipts', [ReceiptController::class, 'index']);
Route::post('receipts', [ReceiptController::class, 'store']);
Route::get('receipts/{receipt}', [ReceiptController::class, 'show']);
Route::patch('receipts/{receipt}/attach-movement', [ReceiptController::class, 'attachMovement']);
Route::delete('receipts/{receipt}', [ReceiptController::class, 'destroy']);

