<?php

use App\Modules\Movements\Controllers\MovementController;
use Illuminate\Support\Facades\Route;

Route::apiResource('movements', MovementController::class);

