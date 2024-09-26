<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Institute\StoreRequest;
use App\Http\Requests\Institute\UpdateRequest;
use App\Models\Institute;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function getAll(Request $request) {}

    public function get(Request $request)
    {
        $sections = Institute::where('status', 'active')->get();

        return response()->json([
            'status' => 'success',
            'sections' => $sections,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $section = Institute::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Section Created Successfully',
            'section' => $section,
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        $section = Institute::where('id', $request->id)->first();
        $section->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Section Updated Successfully',
            'section' => $section,
        ]);
    }

    public function destroy(Request $request)
    {
        $section = Institute::where('id', $request->id)->first();
        $section->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Section Deleted Successfully',
        ]);
    }
}
