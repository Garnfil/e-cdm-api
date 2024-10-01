<?php

use App\Http\Controllers\API\Auth\InstructorAuthenticationController;
use App\Http\Controllers\API\WhiteboardController;
use Illuminate\Support\Facades\Route;

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

Route::post('instructor/login', [InstructorAuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {});
Route::post('/whiteboard/update/{sessionId}', [WhiteboardController::class, 'update']);

// Route::post('login', [AuthController::class, 'login']);
