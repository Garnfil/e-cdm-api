<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\StoreRequest;
use App\Http\Requests\Subject\UpdateRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function getAll(Request $request)
    {
        $sections = Subject::get();

        return response()->json([
            'status' => 'success',
            'sections' => $sections,
        ]);
    }

    public function get(Request $request)
    {
        $sections = Subject::where('status', 'active')->get();

        return response()->json([
            'status' => 'success',
            'sections' => $sections,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $section = Subject::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Section Created Successfully',
            'section' => $section,
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        $section = Subject::where('id', $request->id)->first();
        $section->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Section Updated Successfully',
            'section' => $section,
        ]);
    }

    public function show(Request $request, $id)
    {
        $section = Subject::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'section' => $section,
        ]);
    }

    public function destroy(Request $request)
    {
        $section = Subject::where('id', $request->id)->first();
        $section->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Section Deleted Successfully',
        ]);
    }
}
