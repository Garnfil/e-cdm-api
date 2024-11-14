<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentRequest;
use App\Models\ClassStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    // Show a specific student by ID
    public function show($id)
    {
        $student = Student::find($id);

        if ($student)
        {
            return response()->json(['status' => 'success', 'student' => $student], 200);
        } else
        {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    // Create a new student
    public function store(StudentRequest $request)
    {
        $data = array_merge($request->validated(), ['password' => Hash::make($request->password)]);
        $student = Student::create($data);

        return response()->json(['status' => 'success', 'student' => $student], 201);
    }

    // Update a student
    public function update(StudentRequest $request, $id)
    {
        $student = Student::find($id);

        if ($student)
        {
            $student->update($request->validated());

            return response()->json(['status' => 'success', 'student' => $student], 200);
        } else
        {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    // Delete a student
    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student)
        {
            $student->delete();

            return response()->json(['message' => 'Student deleted successfully'], 200);
        } else
        {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    public function getTotalClassesAndCompletedWorks(Request $request)
    {

    }
}
