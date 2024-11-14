<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Classroom;
use App\Models\Instructor;
use App\Models\SchoolWork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $activities = SchoolWork::where('type', 'activity')
                ->whereHas('activity')
                ->with('activity', 'class', 'instructor');

            return DataTables::of($activities)
                ->addIndexColumn()
                ->addColumn('class', function ($row) {
                    return $row->class->title;
                })
                ->addColumn('instructor', function ($row) {
                    return $row->instructor->firstname.' '.$row->instructor->lastname;
                })
                ->editColumn('due_datetime', function ($row) {
                    return Carbon::parse($row->due_datetime)->format('F d, Y h:i A');
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="'.route('admin.activities.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a class="btn btn-danger btn-sm remove-btn" id="'. $row->id .'"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.activities.index-activities');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classroom::get();
        $instructors = Instructor::get();

        return view('admin-page.activities.create-activity', compact('classes', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $class = Classroom::find($request->class_id);

        $school_work = SchoolWork::create([
            'title' => $request->title,
            'class_id' => $request->class_id,
            'instructor_id' => $request->instructor_id,
            'description' => $request->description,
            'type' => 'activity',
            'status' => $request->status,
            'due_datetime' => $request->due_datetime,
        ]);

        $assignment = Activity::create([
            'school_work_id' => $school_work->id,
            'activity_type' => 'practical',
            'notes' => $request->notes,
            'points' => $request->points,
            'assessment_type' => $class->current_assessment_category,
        ]);

        return redirect()->route('admin.activities.index')->withSuccess('Activity Added Successfully');
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
        $activity = SchoolWork::with('attachments')->findOrFail($id);
        $classes = Classroom::get();
        $instructors = Instructor::get();

        return view('admin-page.activities.edit-activity', compact('activity', 'classes', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $school_work = SchoolWork::with('attachments', 'activity')->findOrFail($id);

        $school_work->update([
            'title' => $request->title,
            'class_id' => $request->class_id,
            'instructor_id' => $request->instructor_id,
            'description' => $request->description,
            'status' => $request->status,
            'due_datetime' => $request->due_datetime,
        ]);

        $school_work->activity->update([
            'school_work_id' => $school_work->id,
            'notes' => $request->notes,
            'points' => $request->points,
        ]);

        return back()->withSuccess('Activity Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = SchoolWork::findOrFail($id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Activity Deleted Successfully'
        ]);
    }
}
