<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DiscussionPost;
use App\Models\Institute;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $discussions = DiscussionPost::query();

            return DataTables::of($discussions)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    $user = $row->user();

                    return $user->firstname.' '.$user->lastname;
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('F d, Y H:i a');
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="'.route('admin.discussions.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a class="btn btn-danger btn-sm remove-btn" id="'. $row->id .'"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.discussions.index-discussions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $institutes = Institute::get();
        $courses = Course::get();

        return view('admin-page.discussions.create-discussion', compact('institutes', 'courses'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user_type = $request->user_type == 'student' ? 'App\Models\Student' : 'App\Models\Instructor';

            $discussion = DiscussionPost::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id,
                'user_type' => $user_type,
                'visibility' => $request->visibility,
                'institute_id' => $request->visibility == 'private' ? $request->institute_id : null,
                'course_id' => $request->visibility == 'private' ? $request->course_id : null,
            ]);

            if ($request->has('attachments') && is_array($request->attachments)) {
                $images = [];
                foreach ($request->attachments as $key => $attachment) {
                    $file_name = null;
                    if (! is_string($attachment)) {
                        $file_name = time().'-'.Str::random(5).'.'.$attachment->getClientOriginalExtension();
                        $file_path = 'discussions/'.$discussion->id.'/';
                        Storage::disk('public')->putFileAs($file_path, $attachment, $file_name);
                    }
                    array_push($images, $file_name);
                }

                $discussion->update(['images' => json_encode($discussion)]);
            }

            DB::commit();

            return redirect()->route('admin.discussions.index')->withSuccess('Discussion Added Successfully.');

        } catch (Exception $exception) {
            return back()->with('fail', $exception->getMessage());
        }
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
        $class = DiscussionPost::find($id);
        $class->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Discussion Deleted Successfully'
        ]);
    }
}
