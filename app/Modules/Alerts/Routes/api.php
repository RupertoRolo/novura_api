<?php

use App\Modules\Alerts\Controllers\AlertController;
use Illuminate\Support\Facades\Route;

Route::get('alerts', [AlertController::class, 'index']);
Route::patch('alerts/{alert}/read', [AlertController::class, 'markRead']);

