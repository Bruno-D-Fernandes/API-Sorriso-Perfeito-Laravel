<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Metadata\Group;
use App\Http\Controllers\DentistaController;
use Illuminate\Support\Facades\Auth;

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

Route::prefix('dentista')->group(function () {

    Route::post('/registro', [DentistaController::class, 'store']);
    Route::post('/login', [DentistaController::class, 'login']);
    Route::put('/update/{id}', [DentistaController::class, 'update']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [DentistaController::class, 'perfil']);
        Route::post('/logout', [DentistaController::class, 'logout']);
        Route::delete('/destroy/{id}', [DentistaController::class, 'destroy']);
    });
});
