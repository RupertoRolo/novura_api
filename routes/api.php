<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    require __DIR__ . '/../app/Modules/Auth/Routes/api.php';

    Route::middleware('auth:sanctum')->group(function () {
        require __DIR__ . '/../app/Modules/Accounts/Routes/api.php';
        require __DIR__ . '/../app/Modules/Movements/Routes/api.php';
        require __DIR__ . '/../app/Modules/Transfers/Routes/api.php';
        require __DIR__ . '/../app/Modules/Categories/Routes/api.php';
        require __DIR__ . '/../app/Modules/Tags/Routes/api.php';
        require __DIR__ . '/../app/Modules/Receipts/Routes/api.php';
        require __DIR__ . '/../app/Modules/Alerts/Routes/api.php';
        require __DIR__ . '/../app/Modules/Dashboard/Routes/api.php';
    });
});
