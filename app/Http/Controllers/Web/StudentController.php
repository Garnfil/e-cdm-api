<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Institute;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::query();

            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->firstname.' '.$row->lastname;
                })
                ->addColumn('institute', function ($row) {
                    return $row->institute->name ?? 'No Institute Found';
                })
                ->addColumn('course', function ($row) {
                    return $row->course->name ?? 'No Course Found';
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="'.route('admin.students.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a class="btn btn-danger btn-sm"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.students.index-students');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $institutes = Institute::get();
        $courses = Course::get();
        $sections = Section::get();

        return view('admin-page.students.create-student', compact('institutes', 'courses', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'password');

        $students = Student::create(array_merge($data, [
            'password' => Hash::make($request->password),
        ]));

        return redirect()->route('admin.students.index')->withSuccess('Student Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $institutes = Institute::get();
        $courses = Course::get();
        $sections = Section::get();
        $student = Student::findOrFail($id);

        return view('admin-page.students.edit-student', compact('institutes', 'courses', 'sections', 'student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);
        $data = $request->except('_token');

        $student->update($data);

        return back()->withSuccess('Student Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function all(Request $request)
    {
        $students = Student::query();

        if ($request->query('id')) {
            $students = $students->where('id', $request->query('id'));
        }

        $students = $students->get();

        return response()->json([
            'students' => $students,
        ]);
    }
}
