<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Instructor;
use App\Models\InstructorAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InstructorAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $data = InstructorAttendance::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('instructor', function ($row) {
                    return $row->instructor->firstname.' '.$row->instructor->lastname;
                })
                ->addColumn('class', function ($row) {
                    return $row->classroom->title;
                })
                ->editColumn('attendance_datetime', function ($row) {
                    return Carbon::parse($row->attendance_datetime)->format('F d, Y h:i A');
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                            <a href="'.route('admin.instructors.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                            <a class="btn btn-danger btn-sm remove-btn" id="'.$row->id.'"><i class="bx bx-trash text-white"></i></a>
                        </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.instructor_attendances.index-instructor-attendances');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructors = Instructor::all();
        $classes = Classroom::all();

        return view('admin-page.instructor_attendances.create-instructor-attendances', compact('instructors', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = InstructorAttendance::find($id);

        $attendance->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Attendance Deleted Successfully',
        ]);
    }
}
