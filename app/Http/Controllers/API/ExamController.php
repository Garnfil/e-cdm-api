<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassSchoolWork;
use App\Models\Exam;
use App\Models\SchoolWork;
use App\Models\SchoolWorkAttachment;
use App\Services\ExceptionHandlerService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    private $exceptionHandlerService;

    public function __construct(ExceptionHandlerService $exceptionHandlerService)
    {
        $this->exceptionHandlerService = $exceptionHandlerService;
    }

    public function get(Request $request)
    {
        $exams = Exam::with('school_work')->get();

        return response()->json([
            'status' => 'success',
            'exams' => $exams,
        ]);
    }

    public function show(Request $request, $id)
    {
        $exam = Exam::where('id', $id)->with('school_work')->first();

        return response()->json([
            'status' => 'success',
            'exam' => $exam,
        ]);
    }

    public function store(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $schoolWork = SchoolWork::create([
                'instructor_id' => $request->instructor_id,
                'title' => $request->title,
                'description' => $request->description,
                'type' => 'exam',
                'status' => $request->status ?? 'posted',
                'due_datetime' => $request->due_datetime,
            ]);

            if (is_array($request->class_ids))
            {
                foreach ($request->class_ids as $key => $class_id)
                {
                    ClassSchoolWork::create([
                        'class_id' => $class_id,
                        'school_work_id' => $schoolWork->id,
                    ]);
                }
            }

            $exam = Exam::create([
                'school_work_id' => $schoolWork->id,
                'notes' => $request->notes,
                'points' => $request->points,
                'assessment_type' => $request->assessment_type,
                'exam_type' => $request->exam_type ?? $request->assessment_type,
            ]);

            if ($request->has('attachments') && is_array($request->attachments))
            {
                foreach ($request->attachments as $key => $attachment)
                {
                    $file_name = null;
                    if (! is_string($attachment))
                    {
                        $file_name = time() . '-' . Str::random(5) . '.' . $attachment->getClientOriginalExtension();
                        $file_path = 'school_works_attachments/';
                        Storage::disk('public')->putFileAs($file_path, $attachment, $file_name);
                    }

                    SchoolWorkAttachment::create([
                        'school_work_id' => $schoolWork->id,
                        'attachment_name' => is_string($attachment) ? $attachment : $file_name,
                        'school_work_type' => $request->type, // quiz, exams, activities, activities
                        'attachment_type' => is_string($attachment) ? 'link' : 'file',
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'exam' => $exam->load('school_work'),
            ]);
        } catch (Exception $exception)
        {
            DB::rollBack();

            return $this->exceptionHandlerService->__generateExceptionResponse($exception);
        }
    }

    public function update(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $exam = Exam::with('school_work')->find($id);

            $exam->school_work->update([
                'title' => $request->title,
                'description' => $request->description,
                'due_datetime' => $request->due_datetime,
            ]);

            $exam->update([
                'points' => $request->points,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Exam Updated Successfully',
            ]);
        } catch (Exception $exception)
        {
            DB::rollBack();

            return $this->exceptionHandlerService->__generateExceptionResponse($exception);
        }
    }

    public function destroy($id)
    {
    }
}
