<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\VideoConferenceRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VideoConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = VideoConferenceRoom::query();

            return DataTables::of($data)
                ->addColumn("class", function ($row) {
                    return $row->classroom->title;
                })
                ->editColumn("scheduled_datetime", function ($row) {
                    return Carbon::parse($row->scheduled_datetime)->format('F d, Y h:i a');
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                    <a href="' . route('admin.video-conference-sessions.show', $row->id) . '" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                    <a class="btn btn-danger btn-sm remove-btn" id="' . $row->id . '"><i class="bx bx-trash text-white"></i></a>
                </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.video_conference_sessions.index-video-conference-sessions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $conference_session = VideoConferenceRoom::findOrFail($id);
        return view('admin-page.video_conference_sessions.show-video-conference-session', compact('conference_session'));
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
        VideoConferenceRoom::findOrFail($id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Video Conference Session Deleted Successfully."
        ]);
    }
}
