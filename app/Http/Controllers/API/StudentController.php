<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassStudent;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getAll(Request $request)
    {
        $students = Student::get();

        return response()->json([
            'status' => 'success',
            'students' => $students,
        ]);
    }

    public function get(Request $request)
    {
        $students = Student::where('status', 'active')->get();

        return response()->json([
            'status' => 'success',
            'students' => $students,
        ]);
    }

    public function class_students(Request $request)
    {
        $class_student_ids = ClassStudent::select('student_id')->pluck('student_id')->toArray();
        $students = Student::whereIn('id', $class_student_ids)->get();

        return response()->json([
            'status' => 'success',
            'students' => $students,
        ]);
    }

    public function store(Request $request) {}

    public function update(Request $request) {}

    public function destroy(Request $request) {}
}
