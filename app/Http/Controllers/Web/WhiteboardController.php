<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Instructor;
use App\Models\WhiteboardSession;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WhiteboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WhiteboardSession::query();

            return DataTables::of($data)
                ->addColumn("classroom", function ($row) {
                    return $row->classroom->title;
                })
                ->addColumn("instructor", function ($row) {
                    return $row->instructor->firstname . ' ' . $row->instructor->lastname;
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                                <a href="' . route('admin.whiteboard-sessions.show', $row->id) . '" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                                <a class="btn btn-danger btn-sm remove-btn" id="' . $row->id . '"><i class="bx bx-trash text-white"></i></a>
                            </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.whiteboard_sessions.index-whiteboard-sessions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classroom::get();
        return view('admin-page.whiteboard_sessions.create-whiteboard-session', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $whiteboard_session = WhiteboardSession::findOrFail($id);
        return view('admin-page.whiteboard_sessions.show-whiteboard-session', compact('whiteboard_session'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $whiteboard_session = WhiteboardSession::findOrFail($id);
        $whiteboard_session->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Whiteboard Session Deleted Successfully"
        ]);

    }
}
