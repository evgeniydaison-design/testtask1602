<?php

use App\Http\Controllers\Api\HousingController;
use Illuminate\Support\Facades\Route;

Route::get('/housings', [HousingController::class, 'index']);
Route::get('/housings/{id}', [HousingController::class, 'show']);