<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $institutes = Institute::query();

            return DataTables::of($institutes)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                            <a href="'.route('admin.institutes.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                            <a class="btn btn-danger btn-sm remove-btn" id="'. $row->id .'"><i class="bx bx-trash text-white"></i></a>
                        </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.institutes.index-institutes');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-page.institutes.create-institute');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        $institute = Institute::create($data);

        return redirect()->route('admin.institutes.index')->withSuccess('Institute Added Successfully');
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
        $institute = Institute::findOrFail($id);

        return view('admin-page.institutes.edit-institute', compact('institute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token', '_method');
        $institute = Institute::findOrFail($id);

        $institute->update($data);

        return back()->withSuccess('Institute Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = Institute::find($id);
        $class->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Institute Deleted Successfully'
        ]);
    }
}
