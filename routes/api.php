<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::middleware('auth:sanctum')->get('/staff', [StaffController::class, 'index']);
