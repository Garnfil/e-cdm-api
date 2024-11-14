<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\SchoolWork;
use App\Models\SchoolWorkAttachment;
use App\Services\ExceptionHandlerService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    private $exceptionHandlerService;

    public function __construct(ExceptionHandlerService $exceptionHandlerService)
    {
        $this->exceptionHandlerService = $exceptionHandlerService;
    }

    public function get(Request $request)
    {
        $activities = Activity::with('school_work')->get();

        return response()->json([
            'status' => 'success',
            'activities' => $activities,
        ]);
    }

    public function show(Request $request, $id)
    {
        $activity = Activity::where('id', $id)->with('school_work')->first();

        return response()->json([
            'status' => 'success',
            'activity' => $activity,
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
                'type' => 'activity',
                'status' => $request->status,
                'due_datetime' => $request->due_datetime,
            ]);

            $activity = Activity::create([
                'school_work_id' => $schoolWork->id,
                'notes' => $request->notes,
                'points' => $request->points,
                'assessment_type' => $request->assessment_type,
                'activity_type' => $request->activity_type ?? 'practical',
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
                        'school_work_type' => $request->type, // quiz, exams, activities, activities
                        'attachment_type' => is_string($attachment) ? 'link' : 'file',
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'activity' => $activity->load('school_work'),
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->exceptionHandlerService->__generateExceptionResponse($exception);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $activity = Activity::with('school_work')->find($id);

            $activity->school_work->update([
                'title' => $request->title,
                'description' => $request->description,
                'due_datetime' => $request->due_datetime,
            ]);

            $activity->update([
                'points' => $request->points,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Activity Updated Successfully',
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->exceptionHandlerService->__generateExceptionResponse($exception);
        }
    }

    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Activity Deleted Successfully'
        ]);
    }
}
