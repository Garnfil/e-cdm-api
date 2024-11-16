<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $sections = Section::query();

            return DataTables::of($sections)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->name . ' - ' . $row->course->name;
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="' . route('admin.sections.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a class="btn btn-danger remove-btn" id="' . $row->id . '"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.sections.index-sections');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::get();

        return view('admin-page.sections.create-section', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        $section = Section::create(array_merge($data, ['status' => 'active']));

        return redirect()->route('admin.sections.index')->withSuccess('Section Added Successfully');
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
        $section = Section::findOrFail($id);
        $courses = Course::get();

        return view('admin-page.sections.edit-section', compact('section', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token');
        $section = Section::findOrFail($id);

        $section->update($data);

        return back()->withSuccess('Section Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = Section::find($id);
        $class->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Quiz Deleted Successfully'
        ]);
    }
}
