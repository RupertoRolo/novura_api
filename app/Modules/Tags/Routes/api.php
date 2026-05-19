<?php

use App\Modules\Tags\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('tags', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);

