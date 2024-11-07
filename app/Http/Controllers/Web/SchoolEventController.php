<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SchoolEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SchoolEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $events = SchoolEvent::query();
            return DataTables::of($events)
                ->addIndexColumn()
                ->editColumn('event_date', function ($row) {
                    return Carbon::parse($row->event_date)->format('F d, Y h:i A');
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="' . route('admin.school-events.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a id="' . $row->id . '" class="btn btn-danger btn-sm remove-btn"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
            ;
        }

        return view('admin-page.school_events.index-school-events');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-page.school_events.create-school-event');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $event = SchoolEvent::create($data);

        return redirect()->route('admin.school-events.index')->withSuccess('School Event Added Successfully');
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
        $event = SchoolEvent::findOrFail($id);
        return view('admin-page.school_events.edit-school-event', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token', '_token');
        $event = SchoolEvent::findOrFail($id);
        $event->update($data);

        return redirect()->back()->withSuccess('School Event Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = SchoolEvent::findOrFail($id);
        $event->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'School Event Deleted Successfully'
        ]);
    }
}
