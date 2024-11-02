<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SchoolWork;
use App\Models\SchoolWorkAttachment;
use App\Services\ExceptionHandlerService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolWorkController extends Controller
{
    public function show(Request $request, $id)
    {
        $school_work = SchoolWork::with('attachments')->find($id);

        if (! $school_work) {
            return response()->json([
                'message' => 'No School Work Found',
            ], 404);
        }

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

        return response()->json([
            'status' => 'success',
            'school_work' => $school_work,
        ]);

    }

    public function uploadSingleAttachment(Request $request)
    {
        try {
            $school_work = SchoolWork::where('id', $request->school_work_id)->first();
            if (! $school_work) {
                throw new Exception('School Work Not Found', 404);
            }

            if ($request->hasFile('attachment') && $request->attachment_type == SchoolWorkAttachment::ATTACHMENT_TYPE_FILE) {
                // dd(true);
                $attachment = $request->file('attachment');

                $path_extension = $attachment->getClientOriginalExtension();

                if (! in_array($path_extension, ['pdf', 'png', 'jpg', 'jpeg', 'webp'])) {
                    throw new Exception('The requested attachment does not correspond to a recognized file type. The following file types are supported: pdf, png, jpg, jpeg, and webp.', 422);
                }

                $attachment_name = Str::random(7).'-'.time().'.'.$attachment->getClientOriginalExtension();

                $file_path = 'school_work_attachments/';
                Storage::disk('public')->putFileAs($file_path, $attachment, $attachment_name);
            } else {
                $attachment_name = $request->attachment;
            }

            SchoolWorkAttachment::create([
                'school_work_id' => $school_work->id,
                'attachment_name' => $attachment_name,
                'school_work_type' => $school_work->type,
                'attachment_type' => $request->attachment_type,
                'status' => 'active',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'School Work Attachment Added Successfully',
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandlerService = new ExceptionHandlerService;

            return $exceptionHandlerService->__generateExceptionResponse($exception);
        }

    }

    public function deleteAttachment(Request $request, $attachment_id)
    {
        $schoolWorkAttachment = SchoolWorkAttachment::where('id', $attachment_id)->first();

        if ($schoolWorkAttachment->attachment_type == SchoolWorkAttachment::ATTACHMENT_TYPE_FILE) {
            // Define the file path
            $file_path = 'school_work_attachments/'.$schoolWorkAttachment->attachment_name;

            // Check if the file exists in the 'public' disk
            if (Storage::disk('public')->exists($file_path)) {
                // Delete the file
                Storage::disk('public')->delete($file_path);
            }
        }

        $schoolWorkAttachment->delete();

        return response()->json(['message' => 'File deleted successfully.']);
    }

    public function quizQuestions(Request $request, $id)
    {
        $school_work = SchoolWork::with('quiz.questions')->find($id);

        return response()->json([
            'status' => 'success',
            'school_work' => $school_work,
        ]);
    }

    public function todoSchoolWorks(Request $request)
    {
        $student_id = $request->student_id;
        $class_id = $request->class_id;

        $today = now();

        $school_works = SchoolWork::where('class_id', $class_id)
            ->where('due_datetime', '>', $today)
            ->whereDoesntHave('student_submissions', function ($query) use ($student_id) {
                $query->where('student_id', $student_id)
                    ->whereNotNull('datetime_submitted');
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'school_works' => $school_works,
        ]);
    }

    public function completedSchoolWorks(Request $request)
    {
        $student_id = $request->student_id;
        $class_id = $request->class_id;

        $school_works = SchoolWork::where('class_id', $class_id)
            ->whereHas('student_submissions', function ($query) use ($student_id) {
                $query->where('student_id', $student_id)
                    ->whereNotNull('datetime_submitted');
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'school_works' => $school_works,
        ]);
    }
}
