<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\SchoolWork;
use App\Services\ExceptionHandlerService;
use DB;
use Exception;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $exceptionHandler;
    public function __construct(ExceptionHandlerService $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    public function getAll()
    {

    }

    public function get()
    {

    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $schoolWork = SchoolWork::create([
                "class_id" => $request->class_id,
                "instructor_id" => $request->instructor_id,
                "title" => $request->title,
                "description" => $request->description,
                "type" => $request->type,
                "status" => $request->status
            ]);

            $quiz = Quiz::create([
                "school_work_id" => $schoolWork->id,
                "notes" => $request->notes,
                "points" => $request->points,
                "assessment_type" => 'prelim',
                "quiz_type" => 'normal',
                "due_datetime" => $request->datetime,
            ]);

            DB::commit();

            return response()->json([
                "status" => "success",
                "schoolWork" => $schoolWork,
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
