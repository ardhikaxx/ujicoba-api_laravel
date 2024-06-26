<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataIbuController;
use App\Http\Controllers\ArtikelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/register', [DataIbuController::class, 'register']);
Route::post('auth/login', [DataIbuController::class, 'login']);
Route::post('auth/check-email', [DataIbuController::class, 'checkEmail']);
Route::post('auth/change-password', [DataIbuController::class, 'changePassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/me', [DataIbuController::class, 'me']);
    Route::post('auth/logout', [DataIbuController::class, 'logout']);
});

Route::get('/artikels', [ArtikelController::class, 'index']);