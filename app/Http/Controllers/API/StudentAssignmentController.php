<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StudentAssignment;
use App\Models\StudentAssignmentAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentAssignmentController extends Controller
{
    public function store(Request $request)
    {
        $student_assignment = StudentAssignment::create([
            'assignment_id' => $request->assignment_id,
            'student_id' => $request->student_id,
            'score' => 0,
            'grade' => 'ungraded',
            'datetime_submitted' => Carbon::now(),
        ]);

        if ($request->has('attachments') && is_array($request->attachments)) {
            foreach ($request->attachments as $key => $attachment) {
                $attachment_name = $attachment['attachment_type'] == 'file' ? Str::random(7) . '-' . time() . $attachment->getClientOriginalExtension() : $attachment['name'];
                $file_path = 'student_assignment_attachments/';
                Storage::disk('public')->putFileAs($file_path, $attachment, $attachment_name);

                StudentAssignmentAttachment::create([
                    'student_assignment_id' => $student_assignment->id,
                    'attachment_name' => $attachment_name,
                    'attachment_type' => $attachment['attachment_type'],
                    'status' => 'submitted',
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'student_assignment' => $student_assignment,
        ]);
    }

    public function show(Request $request, $id)
    {
        $student_assignments = StudentAssignment::find($id);

        return response()->json([
            'status' => 'success',
            'student_assignments' => $student_assignments,
        ]);
    }

    public function submittedStudentActivities(Request $request, $assignment_id)
    {
        $student_assignments = StudentAssignment::where('assignment_id', $assignment_id)
            ->with(['student', 'attachments'])
            ->get();

        return response()->json([
            'status' => 'success',
            'student_assignments' => $student_assignments,
        ]);

    }

    public function submitGradeForStudentAssignment(Request $request)
    {
        $student_assignment_score = $request->score;

        $student_assignment = StudentAssignment::where('id', $request->id)
            ->with(['assignment'])
            ->first();

        $student_assignment_grade = ($student_assignment_score / $student_assignment->assignment->points) * 100;

        $student_assignment->update([
            'score' => $student_assignment_score,
            'grade' => $student_assignment_grade,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'The assignment work graded successfully',
            'student_assignment_grade' => $student_assignment_grade,
        ]);

    }
}
