<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Institute;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $instructors = Instructor::query();

            return DataTables::of($instructors)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->firstname.' '.$row->lastname;
                })
                ->addColumn('institute', function ($row) {
                    return $row->institute->name;
                })
                ->addColumn('course', function ($row) {
                    return $row->course->name;
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                            <a href="'.route('admin.instructors.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                            <a class="btn btn-danger btn-sm remove-btn" id="'. $row->id .'"><i class="bx bx-trash text-white"></i></a>
                        </div>'; 
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.instructors.index-instructor');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $institutes = Institute::get();
        $courses = Course::get();

        return view('admin-page.instructors.create-instructor', compact('institutes', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'password');

        $instructor = Instructor::create(array_merge($data, [
            'password' => Hash::make($request->password),
        ]));

        return redirect()->route('admin.instructors.index')->withSuccess('Instructor Added Successfully');
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
        $instructor = Instructor::findOrFail($id);

        return view('admin-page.instructors.edit-instructor', compact('institutes', 'courses', 'instructor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token', '_method');
        $instructor = Instructor::findOrFail($id);

        $instructor->update($data);

        return back()->withSuccess('Instructor Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instructor = Instructor::findOrFail($id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Instructor Deleted Successfully'
        ]);
    }

    public function all(Request $request)
    {
        $instructors = Instructor::latest()->get();

        return response()->json([
            'instructors' => $instructors,
        ]);
    }
}
