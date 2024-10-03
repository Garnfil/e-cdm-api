<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\SchoolWork;
use App\Models\SchoolWorkAttachment;
use App\Services\ExceptionHandlerService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssignmentController extends Controller
{
    private $exceptionHandlerService;

    public function __construct(ExceptionHandlerService $exceptionHandlerService)
    {
        $this->exceptionHandlerService = $exceptionHandlerService;
    }

    public function get(Request $request)
    {
        $assignments = Assignment::with('school_work')->get();

        return response()->json([
            'status' => 'success',
            'assignments' => $assignments,
        ]);
    }

    public function show(Request $request, $id)
    {
        $assignment = Assignment::where('id', $id)->with('school_work')->first();

        return response()->json([
            'status' => 'success',
            'assignment' => $assignment,
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $schoolWork = SchoolWork::create([
                'class_id' => $request->class_id,
                'instructor_id' => $request->instructor_id,
                'title' => $request->title,
                'description' => $request->description,
                'type' => 'assignment',
                'status' => $request->status,
            ]);

            $assignment = Assignment::create([
                'school_work_id' => $schoolWork->id,
                'notes' => $request->notes,
                'points' => $request->points,
                'assessment_type' => $request->assessment_type,
                'due_datetime' => $request->due_datetime,
            ]);

            if ($request->has('attachments') && is_array($request->attachments)) {
                foreach ($request->attachments as $key => $attachment) {
                    $file_name = null;
                    if (! is_string($attachment)) {
                        $file_name = time().'-'.Str::random(5).'.'.$attachment->getClientOriginalExtension();
                        $file_path = 'school_works_attachments/';
                        Storage::disk('public')->putFileAs($file_path, $attachment, $file_name);
                    }

                    SchoolWorkAttachment::create([
                        'school_work_id' => $schoolWork->id,
                        'attachment_name' => is_string($attachment) ? $attachment : $file_name,
                        'school_work_type' => $request->type, // quiz, exams, activities, assignments
                        'attachment_type' => is_string($attachment) ? 'link' : 'file',
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'assignment' => $assignment->load('school_work'),
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            dd($exception);

            return $this->exceptionHandlerService->__generateExceptionResponse($exception);
        }
    }

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
