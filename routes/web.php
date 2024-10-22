<?php

use App\Http\Controllers\API\WhiteboardController;
use App\Http\Controllers\Web\ActivityController;
use App\Http\Controllers\Web\AssignmentController;
use App\Http\Controllers\Web\AttendanceController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ClassController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ExamController;
use App\Http\Controllers\Web\InstituteController;
use App\Http\Controllers\Web\InstructorController;
use App\Http\Controllers\Web\QuizController;
use App\Http\Controllers\Web\QuizQuestionController;
use App\Http\Controllers\Web\SchoolWorkController;
use App\Http\Controllers\Web\SectionController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\SubjectController;
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

Route::get('admin/login', [AuthController::class, 'login'])->name('login.get');
Route::post('admin/login', [AuthController::class, 'saveLogin'])->name('login.post');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('instructors', InstructorController::class);
    Route::resource('institutes', InstituteController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('assignments', AssignmentController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('quizzes', QuizController::class);
    Route::resource('exams', ExamController::class);
    Route::resource('attendances', AttendanceController::class);

    Route::post('quiz-questions/store', [QuizQuestionController::class, 'store'])->name('quiz_questions.store');

    Route::post('school-works/attachments/upload', [SchoolWorkController::class, 'upload'])->name('school_works.attachments.upload');
});

Route::post('/whiteboard/update/{sessionId}', [WhiteboardController::class, 'update']);
