<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
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

    public function classMessages(Request $request)
    {

        // Retrieve and format messages for the specified class
        $messages = ChatMessage::where('class_id', $request->class_id)->get()->map(function ($message) {
            return [
                'user' => $message->sender,
                'content' => $message->content,
                'created_at' => $message->created_at->toDateTimeString(),
            ];
        });

        return response()->json([
            'status' => 'success',
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, $class_id)
    {
        $classroom = Classroom::find($class_id);

        // Check sender type
        $sender = $request->user_type === 'student'
            ? Student::find($request->user_id)
            : Instructor::find($request->user_id);

        $sender_class = $request->user_type === 'student' ? 'App\Models\Student' : 'App\Models\Instructor';

        if (! $sender)
        {
            return response()->json(['error' => 'Sender not found'], 404);
        }

        $message = ChatMessage::create([
            'class_id' => $classroom->id,
            'sender_id' => $sender->id,
            'sender_type' => $sender_class,
            'content' => $request->content,
        ]);

        $message->load('sender');

        // Broadcast event
        event(new MessageSent($message));

        return response()->json($message, 201);
    }
}
