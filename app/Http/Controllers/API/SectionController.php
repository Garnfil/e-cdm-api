<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Section\StoreRequest;
use App\Http\Requests\Section\UpdateRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function getAll(Request $request)
    {
        $year_level = $request->query('year_level');
        $course_id = $request->query('course_id');
        $sections = Section::when($year_level, function ($q) use ($year_level) {
            return $q->where('year_level', $year_level);
        })
            ->when($course_id, function ($q) use ($course_id) {
                return $q->where('course_id', $course_id);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'sections' => $sections,
        ]);
    }

    public function get(Request $request)
    {
        $sections = Section::where('status', 'active')->get();

        return response()->json([
            'status' => 'success',
            'sections' => $sections,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $section = Section::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Section Created Successfully',
            'section' => $section,
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        $section = Section::where('id', $request->id)->first();
        $section->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Section Updated Successfully',
            'section' => $section,
        ]);
    }

    public function show(Request $request, $id)
    {
        $section = Section::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'section' => $section,
        ]);
    }

    public function destroy(Request $request)
    {
        $section = Section::where('id', $request->id)->first();
        $section->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Section Deleted Successfully',
        ]);
    }
}
