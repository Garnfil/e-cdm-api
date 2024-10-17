<?php

use App\Http\Controllers\API\WhiteboardController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\InstituteController;
use App\Http\Controllers\Web\InstructorController;
use App\Http\Controllers\Web\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('students', StudentController::class);
    Route::resource('instructors', InstructorController::class);
    Route::resource('institutes', InstituteController::class);
    Route::resource('courses', CourseController::class);
});

Route::post('/whiteboard/update/{sessionId}', [WhiteboardController::class, 'update']);
