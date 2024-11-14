<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $attendances = Attendance::query();

            return DataTables::of($attendances)
                ->addIndexColumn()
                ->addColumn('class', function ($row) {
                    return $row->class->title;
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="'.route('admin.attendances.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a class="btn btn-danger btn-sm remove-btn" id="'. $row->id .'"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.attendances.index-attendances');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classroom::get();

        return view('admin-page.attendances.create-attendance', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $attendance_code = Str::random(8);
        $attendance = Attendance::create(array_merge($data, [
            'attendance_code' => $attendance_code,
        ]));

        return redirect()->route('admin.attendances.index')->withSuccess('Attendance Added Successfully');

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
        $classes = Classroom::get();
        $attendance = Attendance::findOrFail($id);

        return view('admin-page.attendances.edit-attendance', compact('classes', 'attendance'));
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
        $attendance = Attendance::find($id);
        $attendance->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'attendance Deleted Successfully'
        ]);
    }
}
