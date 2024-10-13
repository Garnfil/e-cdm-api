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
use App\Http\Controllers\API\ModuleController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\QuizQuestionController;
use App\Http\Controllers\API\SchoolWorkController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\StudentAssignmentController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\StudentQuizController;
use App\Http\Controllers\API\StudentSubmissionController;
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
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'getAll']);
        Route::get('/{id}', [StudentController::class, 'show']);
        Route::post('/', [StudentController::class, 'store']);
        Route::put('/{id}', [StudentController::class, 'update']);
        Route::delete('/{id}', [StudentController::class, 'destroy']);
    });

    Route::get('classes', [ClassRoomController::class, 'getAll']);
    Route::post('classes', [ClassRoomController::class, 'store']);
    Route::get('classes/active', [ClassRoomController::class, 'get']);
    Route::post('classes/join', [ClassRoomController::class, 'classJoinStudent']);
    Route::get('classes/{class_id}/school-works', [ClassRoomController::class, 'getClassSchoolWorks']);
    Route::get('classes/{class_id}/students', [ClassRoomController::class, 'getClassStudents']);
    Route::get('classes/{id}', [ClassRoomController::class, 'show']);
    Route::get('instructors/{instructor_id}/classes', [ClassRoomController::class, 'getInstructorClasses']);

    Route::post('school-works/attachments/single-upload', [SchoolWorkController::class, 'uploadSingleAttachment']);
    Route::delete('school-works/attachments/{attachment_id}/destroy', [SchoolWorkController::class, 'deleteAttachment']);
    Route::get('school-works/{id}', [SchoolWorkController::class, 'show']);

    Route::post('student-school-works/submissions', [StudentSubmissionController::class, 'store']);
    Route::post('student-school-works/submissions/{submission_id}/graded', [StudentSubmissionController::class, 'gradeStudentSubmission']);
    Route::get('student-school-works/submissions/{submission_id}', [StudentSubmissionController::class, 'show']);
    Route::get('student-school-works/{school_work_id}/submissions', [StudentSubmissionController::class, 'schoolWorkStudentSubmissions']);

    Route::get('quizzes', [QuizController::class, 'getAll']);
    Route::post('quizzes', [QuizController::class, 'store']);
    Route::get('quizzes/{id}', [QuizController::class, 'show']);

    Route::post('quiz-questions', [QuizQuestionController::class, 'store']);
    Route::post('quizzes/{quiz_id}/quiz-questions', [QuizQuestionController::class, 'getQuizQuestions']);

    Route::post('student-quizzes/quiz-form/student-answers', [StudentQuizController::class, 'submitStudentAnswer']);

    Route::get('assignments', [AssignmentController::class, 'get']);
    Route::post('assignments', [AssignmentController::class, 'store']);
    Route::get('assignments/{id}', [AssignmentController::class, 'show']);

    Route::post('student-assignments', [StudentAssignmentController::class, 'store']);
    Route::get('student-assignments/submitted/assignments/{assignment_id}', [StudentAssignmentController::class, 'submittedStudentAssignments']);

    Route::get('activities', [ActivityController::class, 'get']);
    Route::post('activities', [ActivityController::class, 'store']);
    Route::get('activities/{id}', [ActivityController::class, 'show']);

    Route::post('student-activities', [StudentAssignmentController::class, 'store']);
    Route::get('student-activities/submitted/activities/{assignment_id}', [StudentAssignmentController::class, 'submittedStudentActivities']);

    Route::get('exams', [ExamController::class, 'get']);
    Route::post('exams', [ExamController::class, 'store']);
    Route::get('exams/{id}', [ExamController::class, 'show']);

    Route::get('classes/{class_id}/modules', [ModuleController::class, 'classModules']);
    Route::prefix('modules')->group(function () {
        Route::get('/', [ModuleController::class, 'getAll']);
        Route::get('/{id}', [ModuleController::class, 'show']);
        Route::post('/', [ModuleController::class, 'store']);
        Route::put('/{id}', [ModuleController::class, 'update']);
        Route::delete('/{id}', [ModuleController::class, 'destroy']);
    });

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
