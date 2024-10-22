<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Instructor;
use App\Models\SchoolWork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->ajax()) {
                $quizzes = SchoolWork::where('type', 'quiz')
                    ->whereHas('quiz')
                    ->with('quiz', 'class', 'instructor');

                return DataTables::of($quizzes)
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
                            <a href="'.route('admin.quizzes.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                            <a class="btn btn-danger btn-sm"><i class="bx bx-trash text-white"></i></a>
                        </div>';
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }
        }

        return view('admin-page.quizzes.index-quizzes');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classroom::get();
        $instructors = Instructor::get();

        return view('admin-page.quizzes.create-quiz', compact('classes', 'instructors'));
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
        $quiz = SchoolWork::with('quiz')->findOrFail($id);
        $classes = Classroom::get();
        $instructors = Instructor::get();

        return view('admin-page.quizzes.edit-quiz', compact('quiz', 'classes', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $school_work = SchoolWork::with('attachments', 'quiz')->findOrFail($id);

        $school_work->update([
            'title' => $request->title,
            'class_id' => $request->class_id,
            'instructor_id' => $request->instructor_id,
            'description' => $request->description,
            'status' => $request->status,
            'due_datetime' => $request->due_datetime,
        ]);

        $school_work->quiz->update([
            'school_work_id' => $school_work->id,
            'notes' => $request->notes,
            'quiz_type' => $request->quiz_type,
            'has_quiz_form' => $request->has('has_quiz_form') ? true : false,
            'points' => $request->points,
        ]);

        return back()->withSuccess('Quiz Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
