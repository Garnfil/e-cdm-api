<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InstructorAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InstructorAttendanceController extends Controller
{
    public function getFirstInstructorAttendance()
    {
        $attendance = InstructorAttendance::where('is_read', 0)
            ->with('instructor', 'classroom')
            ->first();

        if (! $attendance)
        {
            return response()->json([
                'message' => "No record found",
            ], 400);
        }

        $result = [
            'id' => $attendance->id,
            'instructor' => $attendance->instructor->firstname.' '.$attendance->instructor->lastname,
            'class' => ($attendance->classroom->section->name ?? '').' - '.($attendance->classroom->subject->code ?? ''),
            'room' => $attendance->room,
            'attendance_date' => Carbon::parse($attendance->attendance_date)->format('M d, Y'),
        ];

        return response()->json([
            'status' => 'success',
            'attendance' => $result
        ]);
    }

    public function updateNotification(Request $request)
    {
        $attendance = InstructorAttendance::find($request->id);

        $attendance->update([
            'is_read' => true ?? 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification Updated Successfully',
        ]);
    }
}
