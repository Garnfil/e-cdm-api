<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discussion\StoreRequest;
use App\Models\DiscussionPost;
use App\Services\ExceptionHandlerService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiscussionForumController extends Controller
{
    public function getAll(Request $request)
    {
        $discussions = DiscussionPost::get();
    }

    public function get(Request $request)
    {
        $user = auth()->user();  // Assuming the user is authenticated

        $discussions = DiscussionPost::where('visibility', 'public')
            ->orWhere(function ($query) use ($user) {
                $query->where('visibility', 'private')
                    ->where(function ($q) use ($user) {
                        $q->where('institute_id', $user->institute_id)
                            ->orWhere('course_id', $user->course_id);
                    });
            })
            ->latest()  // Sort by latest posts
            ->get();

        $discussions->each(function ($discussion) {
            $discussion->user = $discussion->user();
        });

        return response()->json([
            'status' => 'success',
            'discussions' => $discussions,
        ]);
    }

    public function show(Request $request, $id)
    {
        $discussion = DiscussionPost::where('id', $id)
            ->with('comments')
            ->first();

        $discussion->user = $discussion->user();

        return response()->json([
            'status' => 'success',
            'discussion' => $discussion,
        ]);
    }

    public function ownerDiscussions(Request $request)
    {
        $discussions = DiscussionPost::where('user_id', $request->user_id)
            ->where('user_type', $request->user_type)
            ->get();

        return response()->json([
            'status' => 'success',
            'discussions' => $discussions,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $discussion = DiscussionPost::create([
                'title' => $request->title,
                'content' => $request->discussion_content,
                'user_id' => $request->user_id,
                'user_type' => $request->user_type,
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

            return response()->json([
                'status' => 'success',
                'discussion' => $discussion,
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandlerService = new ExceptionHandlerService;

            return $exceptionHandlerService->__generateExceptionResponse($exception);
        }
    }

    public function update(Request $request, $id) {}

    public function vote(Request $request) {}

    public function destroy(Request $request) {}
}
