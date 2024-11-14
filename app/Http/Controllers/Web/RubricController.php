<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassRubric;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RubricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $data = ClassRubric::query();
            return DataTables::of($data)
                ->addColumn('classroom', function ($row) {
                    return $row->classroom->title;
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                            <a href="' . route('admin.rubrics.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                            <a class="btn btn-danger btn-sm remove-btn" id="' . $row->id . '"><i class="bx bx-trash text-white"></i></a>
                        </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.rubrics.index-rubrics');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classroom::get();
        return view('admin-page.rubrics.create-rubric', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $total_percentage = $request->assignment_percentage + $request->quiz_percentage + $request->activity_percentage + $request->exam_percentage + $request->attendance_percentage + $request->other_performance_percentage;
        if ($total_percentage > 100)
        {
            return back()->with('fail', 'The total percentage of your inputs is greater than 100');
        }

        $rubric = ClassRubric::updateOrCreate([
            'class_id' => $request->class_id,
        ], $data);

        return redirect()->route('admin.rubrics.index')->withSuccess('Created Successfully');

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
        $rubric = ClassRubric::findOrFail($id);
        $classes = Classroom::get();
        return view('admin-page.rubrics.edit-rubric', compact('rubric', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token');
        $rubric = ClassRubric::findOrFail($id);

        $total_percentage = $request->assignment_percentage + $request->quiz_percentage + $request->activity_percentage + $request->exam_percentage + $request->attendance_percentage + $request->other_performance_percentage;
        if ($total_percentage > 100)
        {
            return back()->with('fail', 'The total percentage of your inputs is greater than 100');
        }

        $rubric->update($data);
        return back()->withSuccess("Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = ClassRubric::find($id);
        $class->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Rubric Deleted Successfully'
        ]);
    }
}
