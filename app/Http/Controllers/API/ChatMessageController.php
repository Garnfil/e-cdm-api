<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Instructor;
use App\Models\Student;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function index(Classroom $class)
    {
        return $class->messages()->with('user')->orderBy('created_at')->get();
    }

    public function store(Request $request, Classroom $class)
    {
        // Check sender type
        $sender = $request->user_type === 'student'
            ? Student::find($request->user_id)
            : Instructor::find($request->user_id);

        if (! $sender) {
            return response()->json(['error' => 'Sender not found'], 404);
        }

        // Create message
        $message = $class->messages()->create([
            'sender_id' => $sender->id,
            'sender_type' => get_class($sender),
            'content' => $request->content,
        ]);

        // Broadcast event
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message, 201);
    }
}
