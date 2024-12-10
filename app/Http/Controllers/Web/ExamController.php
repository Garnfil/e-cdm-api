<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassSchoolWork;
use App\Models\Exam;
use App\Models\Instructor;
use App\Models\SchoolWork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $exams = SchoolWork::where('type', 'exam')
                ->whereHas('exam')
                ->with('activity', 'school_work_class', 'instructor');

            return DataTables::of($exams)
                ->addIndexColumn()
                ->addColumn('class', function ($row) {
                    return $row->school_work_class->classroom->title;
                })
                ->addColumn('instructor', function ($row) {
                    return $row->instructor->firstname . ' ' . $row->instructor->lastname;
                })
                ->editColumn('due_datetime', function ($row) {
                    return Carbon::parse($row->due_datetime)->format('F d, Y h:i A');
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="' . route('admin.exams.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a class="btn btn-danger btn-sm remove-btn" id="' . $row->id . '"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
            ;
        }

        return view('admin-page.exams.index-exams');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classroom::get();
        $instructors = Instructor::get();
        return view('admin-page.exams.create-exam', compact('classes', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $classes = Classroom::whereIn('id', $request->class_ids)->get();

        $school_work = SchoolWork::create([
            'title' => $request->title,
            'instructor_id' => $request->instructor_id,
            'description' => $request->description,
            'type' => 'exam',
            'status' => $request->status,
            'due_datetime' => $request->due_datetime,
        ]);

        if (is_array($request->class_ids))
        {
            foreach ($request->class_ids as $key => $class_id)
            {
                ClassSchoolWork::updateOrCreate([
                    'class_id' => $class_id,
                    'school_work_id' => $school_work->id
                ], []);
            }
        }

        foreach ($classes as $key => $classroom)
        {
            $exam = Exam::create([
                'school_work_id' => $school_work->id,
                'notes' => $request->notes,
                'points' => $request->points,
                'exam_type' => 'long',
                'assessment_type' => $classroom->current_assessment_category,
            ]);
        }

        return redirect()->route('admin.exams.index')->withSuccess('Exam Added Successfully');
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
        $exam = SchoolWork::findOrFail($id);
        $classes = Classroom::get();
        $instructors = Instructor::get();

        return view('admin-page.exams.edit-exam', compact('exam', 'classes', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $school_work = SchoolWork::with('attachments', 'exam')->findOrFail($id);

        $school_work->update([
            'title' => $request->title,
            'instructor_id' => $request->instructor_id,
            'description' => $request->description,
            'status' => $request->status,
            'due_datetime' => $request->due_datetime,
        ]);

        if (is_array($request->class_ids))
        {
            foreach ($request->class_ids as $key => $class_id)
            {
                ClassSchoolWork::updateOrCreate([
                    'class_id' => $class_id,
                    'school_work_id' => $school_work->id
                ], []);
            }
        }

        $school_work->exam->update([
            'school_work_id' => $school_work->id,
            'notes' => $request->notes,
            'points' => $request->points,
        ]);

        return back()->withSuccess('Exam Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = SchoolWork::find($id);
        $class->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Exam Deleted Successfully'
        ]);
    }
}
