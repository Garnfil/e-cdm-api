<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Instructor;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $classes = Classroom::query();

            return DataTables::of($classes)
                ->addIndexColumn()
                ->addColumn('subject', function ($row) {
                    return $row->subject->title;
                })
                ->addColumn('section', function ($row) {
                    return $row->section->name;
                })
                ->addColumn('instructor', function ($row) {
                    return $row->instructor->firstname.' '.$row->instructor->lastname;
                })->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="'.route('admin.classes.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a class="btn btn-danger btn-sm"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.classes.index-classes');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::get();
        $sections = Section::get();
        $instructors = Instructor::get();

        return view('admin-page.classes.create-class', compact('subjects', 'sections', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        $section = Section::where('id', $request->section_id)->first();
        $subject = Subject::where('id', $request->subject_id)->first();

        $title = $section->name.' - '.$subject->title;

        $classCode = Str::random(12);

        $existingClassroom = Classroom::where([
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
        ])->exists();

        if ($existingClassroom) {
            return back()->with('failed', 'This class was already exist.');
        }

        $class = Classroom::create(array_merge($data, [
            'class_code' => $classCode,
            'status' => 'active',
            'title' => $title,
        ]));

        return redirect()->route('admin.classes.index')->withSuccess('Class Added Successfully');
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
        $class = Classroom::findOrFail($id);
        $subjects = Subject::get();
        $sections = Section::get();
        $instructors = Instructor::get();

        return view('admin-page.classes.edit-class', compact('class', 'subjects', 'sections', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token', '_method');
        $class = Classroom::findOrFail($id);

        $class->update($data);

        return back()->withSuccess('Class Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
