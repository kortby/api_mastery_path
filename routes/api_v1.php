<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\ApiV1TicketController;
use App\Http\Controllers\Api\V1\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->resource('/tickets', ApiV1TicketController::class);
Route::middleware('auth:sanctum')->resource('/users', UserController::class);
