<?php

use App\Http\Controllers\Web\ActivityController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AssignmentController;
use App\Http\Controllers\Web\AttendanceController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ClassController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DiscussionController;
use App\Http\Controllers\Web\ExamController;
use App\Http\Controllers\Web\GuardianController;
use App\Http\Controllers\Web\InstituteController;
use App\Http\Controllers\Web\InstructorController;
use App\Http\Controllers\Web\QuizController;
use App\Http\Controllers\Web\QuizQuestionController;
use App\Http\Controllers\Web\RubricController;
use App\Http\Controllers\Web\SchoolEventController;
use App\Http\Controllers\Web\SchoolWorkController;
use App\Http\Controllers\Web\SectionController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\SubjectController;
use App\Http\Controllers\Web\VideoConferenceController;
use App\Http\Controllers\Web\WhiteboardController;
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
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('login.get');
    }
});

Route::get('admin/login', [AuthController::class, 'login'])->name('login.get');
Route::post('admin/login', [AuthController::class, 'saveLogin'])->name('login.post');

Route::get('verify-email', [AuthController::class, 'verifyEmail'])->name('verify-email');
Route::view('email-verification-success', 'misc.verification-success')->name('email-verification-success');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('dashboard.profile');

    Route::post('profile/change-password', [DashboardController::class, 'changePassword'])->name('dashboard.profile.change-password');
    Route::post('profile', [DashboardController::class, 'updateAdminProfile'])->name('dashboard.profile.post');

    Route::resource('admins', AdminController::class);

    Route::get('students/all', [StudentController::class, 'all']);
    Route::resource('students', StudentController::class);

    Route::get('instructors/all', [InstructorController::class, 'all']);
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
    Route::resource('discussions', DiscussionController::class);
    Route::resource('guardians', GuardianController::class);
    Route::resource('school-events', SchoolEventController::class);
    Route::resource('video-conference-sessions', VideoConferenceController::class);
    Route::resource('whiteboard-sessions', WhiteboardController::class);
    Route::resource('rubrics', RubricController::class);

    Route::post('quiz-questions/store', [QuizQuestionController::class, 'store'])->name('quiz_questions.store');
    Route::post('school-works/attachments/upload', [SchoolWorkController::class, 'upload'])->name('school_works.attachments.upload');

});

