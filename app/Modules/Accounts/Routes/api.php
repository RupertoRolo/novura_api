<?php

use App\Modules\Accounts\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::apiResource('accounts', AccountController::class);

