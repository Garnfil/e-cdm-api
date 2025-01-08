<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\InstructorAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function store(Request $request) {

        $user = auth()->user();

        $attendance = InstructorAttendance::create($request->only('instructor_id', 'class_id', 'room', 'attendance_datetime'));

        $attendance_code = Str::random(6) . '-' . rand(10000, 100000);
        $student_attendance = Attendance::create(array_merge($request->only('class_id', 'attendance_datetime'), ['attendance_code' => $attendance_code]));

        return response()->json([
            'status' => 'success',
            'attendance' => $attendance
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
