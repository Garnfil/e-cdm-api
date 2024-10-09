<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    public function store(Request $request)
    {
        $studentAttendance = StudentAttendance::create($request->all());
    }

    public function attendanceStudents(Request $request, $attendance_id)
    {
        $students = StudentAttendance::where("attendance_id", $attendance_id)
            ->pluck('student_id')
            ->toArray();

        return response()->json([]);
    }
}
