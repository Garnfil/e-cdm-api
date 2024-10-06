<?php

namespace App\Http\Controllers;

use App\Models\StudentActivity;
use App\Models\StudentActivityAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentActivityController extends Controller
{
    public function store(Request $request)
    {
        $student_activity = StudentActivity::create([
            'activity_id' => $request->activity_id,
            'student_id' => $request->student_id,
            'score' => 0,
            'grade' => 'ungraded',
            'datetime_submitted' => Carbon::now(),
        ]);

        if ($request->has('attachments') && is_array($request->attachments)) {
            foreach ($request->attachments as $key => $attachment) {
                $attachment_name = $attachment['attachment_type'] == 'file' ? Str::random(7).'-'.time().$attachment->getClientOriginalExtension() : $attachment['name'];
                $file_path = 'student_activity_attachments/';
                Storage::disk('public')->putFileAs($file_path, $attachment, $attachment_name);

                StudentActivityAttachment::create([
                    'student_activity_id' => $student_activity->id,
                    'attachment_name' => $attachment_name,
                    'attachment_type' => $attachment['attachment_type'],
                    'status' => 'submitted',
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'student_activity' => $student_activity,
        ]);
    }

    public function show(Request $request, $id)
    {
        $student_activity = StudentActivity::find($id);

        return response()->json([
            'status' => 'success',
            'student_activity' => $student_activity,
        ]);
    }

    public function submittedStudentActivities(Request $request, $activity_id)
    {
        $student_activities = StudentActivity::where('activity_id', $activity_id)
            ->with('student')
            ->get();

        return response()->json([
            'status' => 'success',
            'student_activities' => $student_activities,
        ]);

    }

    public function submitGradeForStudentActivity(Request $request)
    {
        $student_activity_score = $request->score;

        $student_activity = StudentActivity::where('id', $request->id)
            ->with(['activity'])
            ->first();

        $student_activity_grade = ($student_activity_score / $student_activity->activity->points) * 100;

        $student_activity->update([
            'score' => $student_activity_score,
            'grade' => $student_activity_grade,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'The activity work graded successfully',
            'student_activity_grade' => $student_activity_grade,
        ]);

    }
}
