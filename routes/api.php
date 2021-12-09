<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\SensorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [UserProfileController::class, 'index']);
    Route::post('/profile', [UserProfileController::class, 'update']);

    Route::get('/fields', [FieldController::class, 'index']);
    Route::post('/fields', [FieldController::class, 'store']);
    Route::get('/fields/{id}', [FieldController::class, 'show']);
    Route::patch('/fields/{id}', [FieldController::class, 'update']);
    Route::delete('/fields/{id}', [FieldController::class, 'destroy']);

    Route::get('/sensors', [SensorController::class, 'index']);
    Route::post('/sensors', [SensorController::class, 'store']);
    Route::get('/sensors/{id}', [SensorController::class, 'show']);
    Route::patch('/sensors/{id}', [SensorController::class, 'update']);
    Route::delete('/sensors/{id}', [SensorController::class, 'destroy']);
});
