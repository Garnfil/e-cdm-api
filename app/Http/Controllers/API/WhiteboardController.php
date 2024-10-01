<?php

namespace App\Http\Controllers\API;

use App\Events\WhiteboardUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WhiteboardController extends Controller
{
    public function update(Request $request, $sessionId)
    {

        // Broadcast the data to the session's Pusher channel
        $data = $request->input('data');
        broadcast(new WhiteboardUpdated($data, $sessionId))->toOthers();

        return response()->json(['status' => 'Whiteboard updated']);
    }
}
