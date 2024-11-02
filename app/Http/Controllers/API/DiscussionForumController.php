<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discussion\StoreRequest;
use App\Models\DiscussionComment;
use App\Models\DiscussionPost;
use App\Models\DiscussionVote;
use App\Services\ExceptionHandlerService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $discussion = DiscussionPost::where('id', $id)
            ->with([
                'votes',
                'comments.user',
            ])
            ->first();

        $user_type = $user->role == 'student' ? 'App\Models\Student' : 'App\Models\Instructor';

        $user_discussion_vote = DiscussionVote::where('post_id', $discussion->id)
            ->where('user_id', $user->id)
            ->where('user_type', $user_type)->first();

        $discussion->user = $discussion->user();
        $discussion->upvotes_count = $discussion->upvotesCount();
        $discussion->downvotes_count = $discussion->downvotesCount();
        $discussion->user_vote_type = $user_discussion_vote->vote_type;
        $discussion->user_has_vote = $user_discussion_vote->exists() ? true : false;

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
            $user_type = $request->user_type == 'student' ? 'App\Models\Student' : 'App\Models\Instructor';

            $discussion = DiscussionPost::create([
                'title' => $request->title,
                'content' => $request->discussion_content,
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

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
            'user_id' => 'required|integer',
            'user_type' => 'required|in:student,instructor',
        ]);

        $user_type = $request->user_type == 'student' ? 'App\Models\Student' : 'App\Models\Instructor';

        $comment = new DiscussionComment;
        $comment->post_id = $id;
        $comment->user_id = $request->user_id;
        $comment->user_type = $user_type;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json($comment);
    }

    public function storeVote(Request $request, $id)
    {
        $request->validate([
            'vote_type' => 'required|in:upvote,downvote',
            'user_id' => 'required|integer',
            'user_type' => 'required|in:student,instructor',
        ]);

        $user_type = $request->user_type == 'student' ? 'App\Models\Student' : 'App\Models\Instructor';

        $vote = DiscussionVote::updateOrCreate([
            'post_id' => $id,
            'comment_id' => $request->comment_id ?? null,
            'user_id' => $request->user_id,
            'user_type' => $user_type,
        ], ['vote_type' => $request->vote_type]);

        return response()->json([
            'status' => 'success',
            'vote' => $vote,
        ]);
    }

    public function update(Request $request, $id) {}

    public function vote(Request $request) {}

    public function destroy(Request $request) {}
}
