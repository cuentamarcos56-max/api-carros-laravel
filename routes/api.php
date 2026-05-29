<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarroController;

Route::apiResource('carros', CarroController::class);