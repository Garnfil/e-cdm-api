<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $studentAttendance = StudentAttendance::create(array_merge($data, ['attendance_datetime' => Carbon::now(), 'status' => 'present']));

        return response()->json([
            'status' => 'success',
            'student_attendance' => $studentAttendance,
        ], 201);
    }

    public function attendanceStudents(Request $request, $attendance_id)
    {
        $students = StudentAttendance::where('attendance_id', $attendance_id)
            ->pluck('student_id')
            ->toArray();

        return response()->json([]);
    }
}
