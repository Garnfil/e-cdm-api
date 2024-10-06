<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRoom\StoreRequest;
use App\Models\Classroom;
use App\Models\ClassStudent;
use App\Models\SchoolWork;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Services\ExceptionHandlerService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassRoomController extends Controller
{
    private $exceptionHandler;

    public function __construct(ExceptionHandlerService $exceptionHandlerService)
    {
        $this->exceptionHandler = $exceptionHandlerService;
    }

    public function getAll(Request $request) {}

    public function get(Request $request)
    {
        $user = auth()->user();
        $classes = Classroom::where('status', 'active')->get();

        return response()->json([
            'status' => 'success',
            'classes' => $classes,
        ]);
    }

    public function getInstructorClasses(Request $request)
    {
        $classes = Classroom::where('instructor_id', $request->instructor_id)->get();

        return response()->json([
            'status' => 'success',
            'classes' => $classes,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $user = auth()->user();

            DB::beginTransaction();
            $data = $request->validated();

            $section = Section::where('id', $request->section_id)->first();
            $subject = Subject::where('id', $request->subject_id)->first();

            $title = $section->name.' - '.$subject->title;

            $classCode = Str::random(12);

            $existingClassroom = Classroom::where([
                'section_id' => $request->section_id,
                'subject_id' => $request->subject_id,
            ])->exists();

            // Check if the classroom already exist.
            if ($existingClassroom) {
                throw new Exception('Classroom already exists.', 422);
            }

            $class = Classroom::create(array_merge($data, [
                'class_code' => $classCode,
                'status' => 'active',
                'title' => $title,
            ]));

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Class Created Successfully',
                'class' => $class,
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);

            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $class = ClassRoom::where('id', $request->id)->firstOrFail();

            $class->update(attributes: $data);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Class Updated Successfully',
                'class' => $class,
            ]);

        } catch (Exception $exception) {
            DB::rollBack();

            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }

    public function show(Request $request, $id)
    {
        $classroom = Classroom::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'class' => $classroom,
        ]);
    }

    public function updateCoverPhoto(Request $request) {}

    public function destroy(Request $request) {}

    public function getClassStudents(Request $request, $class_id)
    {
        $class_student_ids = ClassStudent::where('class_id', $class_id)->pluck('student_id')->toArray();

        $students = Student::whereIn('id', $class_student_ids)->get();

        return response()->json([
            'status' => 'success',
            'students' => $students,
        ]);
    }

    public function getClassSchoolWorks(Request $request, $class_id)
    {
        $school_works = SchoolWork::where('class_id', $class_id)->get();

        $school_works->each(function ($school_work) {
            switch ($school_work->type) {
                case 'assignment':
                    $school_work->load('assignment');
                    break;

                case 'activity':
                    $school_work->load('activity');
                    break;

                case 'quiz':
                    $school_work->load('quiz');
                    break;

                case 'exam':
                    $school_work->load('exam');
                    break;
            }
        });

        return response()->json([
            'status' => 'success',
            'school_works' => $school_works,
        ]);
    }

    public function classJoinStudent(Request $request)
    {
        $class = Classroom::where('class_code', $request->class_code)->first();

        if (! $class) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Class Code Invalid',
            ], 404);
        }

        ClassStudent::updateOrCreate([
            'student_id' => $request->student_id,
            'class_id' => $class->id,
        ], ['status' => 'active']);

        return response()->json([
            'status' => 'success',
            'message' => 'Joined Class Successfully',
        ]);

    }
}
