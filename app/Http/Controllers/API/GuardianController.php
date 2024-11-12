<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentGuardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    public function getGuardianChildren(Request $request, $guardian_id)
    {
        $student_ids = StudentGuardian::where('guardian_id', $guardian_id)->pluck('student_id')->toArray();

        $students = Student::whereIn('id', $student_ids)->get();

        return response()->json([
            'status' => 'success',
            'students' => $students,
        ]);
    }
}
