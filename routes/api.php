<?php

use App\Http\Controllers\API\ActivityController;
use App\Http\Controllers\API\AssignmentController;
use App\Http\Controllers\API\Auth\InstructorAuthenticationController;
use App\Http\Controllers\API\Auth\StudentAuthenticationController;
use App\Http\Controllers\API\ClassRoomController;
use App\Http\Controllers\API\ClassScheduleController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\DiscussionForumController;
use App\Http\Controllers\API\ExamController;
use App\Http\Controllers\API\InstituteController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\SubjectController;
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

Route::post('student/login', [StudentAuthenticationController::class, 'login']);
Route::post('student/register', [StudentAuthenticationController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('classes', [ClassRoomController::class, 'getAll']);
    Route::post('classes', [ClassRoomController::class, 'store']);
    Route::get('classes/active', [ClassRoomController::class, 'get']);
    Route::get('classes/{class_id}/students', [ClassRoomController::class, 'classStudents']);
    Route::get('classes/{id}', [ClassRoomController::class, 'show']);
    Route::get('/instructors/{instructor_id}/classes', [ClassRoomController::class, 'getInstructorClasses']);

    Route::get('quizzes', [QuizController::class, 'getAll']);
    Route::post('quizzes', [QuizController::class, 'store']);
    Route::get('quizzes/{id}', [QuizController::class, 'show']);

    Route::get('assignments', [AssignmentController::class, 'get']);
    Route::post('assignments', [AssignmentController::class, 'store']);
    Route::get('assignments/{id}', [AssignmentController::class, 'show']);

    Route::get('activities', [ActivityController::class, 'get']);
    Route::post('activities', [ActivityController::class, 'store']);
    Route::get('activities/{id}', [ActivityController::class, 'show']);

    Route::get('exams', [ExamController::class, 'get']);
    Route::post('exams', [ExamController::class, 'store']);
    Route::get('exams/{id}', [ExamController::class, 'show']);

    Route::get('sections', [SectionController::class, 'getAll']);
    Route::get('sections/active', [SectionController::class, 'get']);
    Route::get('sections/{id}', [SectionController::class, 'show']);

    Route::get('subjects', [SubjectController::class, 'getAll']);
    Route::get('subjects/active', [SubjectController::class, 'get']);
    Route::get('subjects/{id}', [SubjectController::class, 'show']);

    Route::get('courses', [CourseController::class, 'getAll']);
    Route::get('courses/active', [CourseController::class, 'get']);
    Route::get('courses/{id}', [CourseController::class, 'show']);

    Route::get('institutes', [InstituteController::class, 'getAll']);
    Route::get('institutes/active', [InstituteController::class, 'get']);
    Route::get('institutes/{id}', [InstituteController::class, 'show']);

    Route::get('discussions', [DiscussionForumController::class, 'get']);
    Route::post('discussions', [DiscussionForumController::class, 'store']);
    Route::get('users/{user_id}/{user_type}/discussions', [DiscussionForumController::class, 'ownerDiscussions']);
    Route::get('discussions/{id}', [DiscussionForumController::class, 'show']);

    Route::get('class-schedules', [ClassScheduleController::class, 'get']);
    Route::post('class-schedules', [ClassScheduleController::class, 'store']);
    Route::post('instructors/{instructor_id}/class-schedules', [ClassScheduleController::class, 'instructorClassesSchedule']);
});

Route::post('whiteboard/update/{sessionId}', [WhiteboardController::class, 'update']);

// Route::post('login', [AuthController::class, 'login']);
