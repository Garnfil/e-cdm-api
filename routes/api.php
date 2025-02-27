<?php

use App\Http\Controllers\API\ActivityController;
use App\Http\Controllers\API\AssignmentController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\Auth\InstructorAuthenticationController;
use App\Http\Controllers\API\Auth\StudentAuthenticationController;
use App\Http\Controllers\API\ChatMessageController;
use App\Http\Controllers\API\ClassRoomController;
use App\Http\Controllers\API\ClassScheduleController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\DataReportController;
use App\Http\Controllers\API\DiscussionForumController;
use App\Http\Controllers\API\ExamController;
use App\Http\Controllers\API\GuardianAuthenticationController;
use App\Http\Controllers\API\GuardianController;
use App\Http\Controllers\API\InstituteController;
use App\Http\Controllers\API\InstructorAttendanceController;
use App\Http\Controllers\API\ModuleController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\QuizQuestionController;
use App\Http\Controllers\API\SchoolEventController;
use App\Http\Controllers\API\SchoolWorkController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\StudentAssignmentController;
use App\Http\Controllers\API\StudentAttendanceController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\StudentQuizController;
use App\Http\Controllers\API\StudentSchoolWorkGradeController;
use App\Http\Controllers\API\StudentSubmissionController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\VideoConferenceController;
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

Route::post('guardian/login', [GuardianAuthenticationController::class, 'login']);

Route::get('school-events', [SchoolEventController::class, 'getAll']);

Route::get('courses', [CourseController::class, 'getAll']);
Route::get('institutes', [InstituteController::class, 'getAll']);
Route::get('sections', [SectionController::class, 'getAll']);

Route::get('instructor-attendances/notification', [InstructorAttendanceController::class, 'getFirstInstructorAttendance']);
Route::post('instructor-attendances', [InstructorAttendanceController::class, 'store']);
Route::post('instructor-attendances/update-notification', [InstructorAttendanceController::class, 'updateNotification']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('student/info-register', [StudentController::class, 'studentInfoRegistration']);
    
    Route::post('student/profile/{id}', [ProfileController::class, 'updateStudentProfile']);
    Route::post('instructor/profile/{id}', [ProfileController::class, 'updateInstructorProfile']);
    Route::post('admin/profile/{id}', [ProfileController::class, 'updateAdminProfile']);

    Route::get('student/profile/{id}', [ProfileController::class, 'studentProfile']);
    Route::get('instructor/profile/{id}', [ProfileController::class, 'instructorProfile']);
    Route::get('admin/profile/{id}', [ProfileController::class, 'adminProfile']);

    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'getAll']);
        Route::get('/{id}', [StudentController::class, 'show']);
        Route::post('/', [StudentController::class, 'store']);
        Route::put('/{id}', [StudentController::class, 'update']);
        Route::delete('/{id}', [StudentController::class, 'destroy']);
    });

    Route::get('classes', [ClassRoomController::class, 'getAll']);
    Route::post('classes', [ClassRoomController::class, 'store']);
    Route::get('classes/students/{student_id}', [ClassRoomController::class, 'getStudentClasses']);
    Route::get('classes/student-available-classes', [ClassRoomController::class, 'getStudentAvailableClasses']);
    Route::get('classes/active', [ClassRoomController::class, 'get']);
    Route::post('classes/join', [ClassRoomController::class, 'classJoinStudent']);
    Route::get('classes/{class_id}/school-works', [ClassRoomController::class, 'getClassSchoolWorks']);
    Route::get('classes/{class_id}/students/{student_id}/school-works', [ClassRoomController::class, 'getClassStudentSchoolWorks']);
    Route::get('classes/{class_id}/students', [ClassRoomController::class, 'getClassStudents']);
    Route::get('classes/{id}', [ClassRoomController::class, 'show']);
    Route::get('instructors/{instructor_id}/classes', [ClassRoomController::class, 'getInstructorClasses']);

    Route::post('school-works/attachments/single-upload', [SchoolWorkController::class, 'uploadSingleAttachment']);
    Route::delete('school-works/attachments/{attachment_id}/destroy', [SchoolWorkController::class, 'deleteAttachment']);
    // Route::get('school-works')
    Route::get('school-works/{id}/quizzes/questions', [SchoolWorkController::class, 'quizQuestions']);
    Route::get('school-works/{id}', [SchoolWorkController::class, 'show']);

    Route::post('attendances/students/submit', [StudentAttendanceController::class, 'store']);

    Route::get('attendances/classes/{class_id}/today', [AttendanceController::class, 'getClassAttendanceToday']);
    Route::get('attendances/classes/{class_id}', [AttendanceController::class, 'classAttendances']);
    Route::get('attendances/{attendance_code}', [AttendanceController::class, 'getAttendanceByCode']);
    Route::delete('attendances/{id}', [AttendanceController::class, 'destroy']);

    Route::post('attendances', [AttendanceController::class, 'store']);

    Route::get('students/{student_id}/total-classes-and-completed-works', [StudentController::class, 'getTotalClassesAndCompletedWorks']);

    Route::post('student-school-works/submit-final-grade', [StudentSubmissionController::class, 'submitFinalGrade']);
    Route::post('student-school-works/submissions-with-grade/{school_work_type}', [StudentSubmissionController::class, 'storeWithGrade']);
    Route::post('student-school-works/submissions/{submission_id}/graded', [StudentSubmissionController::class, 'gradeStudentSubmission']);
    Route::post('student-school-works/submissions', [StudentSubmissionController::class, 'store']);

    Route::get('student-school-works/{school_work_id}/submissions/students/{student_id}', [StudentSubmissionController::class, 'classStudentSubmission']);
    Route::get('student-school-works/{school_work_id}/submissions', [StudentSubmissionController::class, 'schoolWorkStudentSubmissions']);
    Route::get('student-school-works/submissions/{submission_id}', [StudentSubmissionController::class, 'show']);

    Route::get('students/{student_id}/classes/{class_id?}/school-works/todos', [SchoolWorkController::class, 'todoSchoolWorks']);
    Route::get('students/{student_id}/classes/{class_id}/school-works/completed', [SchoolWorkController::class, 'completedSchoolWorks']);
    Route::get('students/{student_id}/classes/{class_id}/school-works/missing', [SchoolWorkController::class, 'missingSchoolWorks']);
    Route::get('students/{student_id}/classes/{class_id}/school-work-grades', [StudentSchoolWorkGradeController::class, 'getStudentSchoolWorkGrades']);
    Route::get('students/{student_id}/classes/school-work-grades', [StudentSchoolWorkGradeController::class, 'getStudentAllClassGrades']);
    Route::get('students/{student_id}/classes/final-grades', [StudentSchoolWorkGradeController::class, 'getStudentClassFinalGrades']);


    Route::get('quizzes', [QuizController::class, 'getAll']);
    Route::post('quizzes', [QuizController::class, 'store']);
    Route::put('quizzes/{id}', [QuizController::class, 'update']);
    Route::get('quizzes/{id}', [QuizController::class, 'show']);

    Route::post('quiz-questions', [QuizQuestionController::class, 'store']);
    Route::post('quizzes/{quiz_id}/quiz-questions', [QuizQuestionController::class, 'getQuizQuestions']);

    Route::post('student-quizzes/quiz-form/student-answers', [StudentQuizController::class, 'submitStudentAnswer']);

    Route::get('assignments', [AssignmentController::class, 'get']);
    Route::post('assignments', [AssignmentController::class, 'store']);
    Route::put('assignments/{id}', [AssignmentController::class, 'update']);
    Route::get('assignments/{id}', [AssignmentController::class, 'show']);

    Route::post('student-assignments', [StudentAssignmentController::class, 'store']);
    Route::get('student-assignments/submitted/assignments/{assignment_id}', [StudentAssignmentController::class, 'submittedStudentAssignments']);

    Route::post('activities/multiple-sections', [ActivityController::class, 'storeInMultipleSections']);
    Route::post('activities', [ActivityController::class, 'store']);
    Route::get('activities', [ActivityController::class, 'get']);
    Route::put('activities/{id}', [ActivityController::class, 'update']);
    Route::get('activities/{id}', [ActivityController::class, 'show']);

    Route::post('student-activities', [StudentAssignmentController::class, 'store']);
    Route::get('student-activities/submitted/activities/{assignment_id}', [StudentAssignmentController::class, 'submittedStudentActivities']);

    Route::get('exams', [ExamController::class, 'get']);
    Route::post('exams', [ExamController::class, 'store']);
    Route::put('exams/{id}', [ExamController::class, 'update']);
    Route::get('exams/{id}', [ExamController::class, 'show']);

    Route::get('classes/{class_id}/modules', [ModuleController::class, 'classModules']);
    Route::post('modules/attachments/single-upload', [ModuleController::class, 'uploadSingleAttachment']);
    Route::prefix('modules')->group(function () {
        Route::get('/', [ModuleController::class, 'getAll']);
        Route::get('/{id}', [ModuleController::class, 'show']);
        Route::post('/', [ModuleController::class, 'store']);
        Route::put('/{id}', [ModuleController::class, 'update']);
        Route::delete('/{id}', [ModuleController::class, 'destroy']);
    });

    Route::get('sections/active', [SectionController::class, 'get']);
    Route::get('sections/{id}', [SectionController::class, 'show']);

    Route::get('subjects', [SubjectController::class, 'getAll']);
    Route::get('subjects/active', [SubjectController::class, 'get']);
    Route::get('subjects/{id}', [SubjectController::class, 'show']);

    Route::get('courses/active', [CourseController::class, 'get']);
    Route::get('courses/{id}', [CourseController::class, 'show']);

    Route::get('institutes/active', [InstituteController::class, 'get']);
    Route::get('institutes/{id}', [InstituteController::class, 'show']);

    Route::get('discussions', [DiscussionForumController::class, 'get']);
    Route::post('discussions', [DiscussionForumController::class, 'store']);
    Route::post('discussions/{id}/comments', [DiscussionForumController::class, 'storeComment']);
    Route::post('discussions/{id}/votes', [DiscussionForumController::class, 'storeVote']);
    Route::get('users/{user_id}/{user_type}/discussions', [DiscussionForumController::class, 'ownerDiscussions']);
    Route::get('discussions/{id}', [DiscussionForumController::class, 'show']);

    Route::get('class-schedules', [ClassScheduleController::class, 'get']);
    Route::post('class-schedules', [ClassScheduleController::class, 'store']);
    Route::get('instructors/{instructor_id}/class-schedules', [ClassScheduleController::class, 'instructorClassesSchedule']);
    Route::get('students/{student_id}/class-schedules', [ClassScheduleController::class, 'studentClassesSchedule']);

    Route::post('messages/classes/{class_id}', [ChatMessageController::class, 'store']);
    Route::get('messages/classes/{class_id}', [ChatMessageController::class, 'classMessages']);

    Route::post('live-sessions/leave-session', [VideoConferenceController::class, 'leaveSession']);
    Route::post('live-sessions/joined-session', [VideoConferenceController::class, 'joinedSession']);
    Route::post('live-sessions', [VideoConferenceController::class, 'store']);
    Route::get('live-sessions/students/{student_id}/classes', [VideoConferenceController::class, 'getStudentClassConferenceSessions']);
    Route::get('live-sessions/instructor-recent-classes', [VideoConferenceController::class, 'getRecentInstructorClassSessions']);

    Route::post('whiteboards/generate-room', [WhiteboardController::class, 'generateRoom']);
    Route::post('whiteboards/generate-room-token', [WhiteboardController::class, 'generateRoomToken']);
    Route::post('whiteboards/update/{sessionId}', [WhiteboardController::class, 'update']);
    Route::post('whiteboards/join-whiteboard-session', [WhiteboardController::class, 'joinWhiteboardSession']);
    Route::delete('whiteboards/{whiteboard_id}', [WhiteboardController::class, 'destroy']);

    Route::get('whiteboards/instructors/{instructor_id}', [WhiteboardController::class, 'getInstructorWhiteboards']);
    Route::get('whiteboards/student-classes', [WhiteboardController::class, 'getStudentClassWhiteboards']);
    Route::get('whiteboards/{session_code}', [WhiteboardController::class, 'getUserWhiteboardSession']);

    Route::get('reports/student-performance', [DataReportController::class, 'getStudentPerformance']);

    Route::get('guardians/{guardian_id}/children', [GuardianController::class, 'getGuardianChildren']);
});
