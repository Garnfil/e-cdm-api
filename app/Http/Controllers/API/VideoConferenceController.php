<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoConference\StoreRequest;
use App\Models\VideoConferenceRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoConferenceController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $session_code = Str::random(8);

        $conference_session = VideoConferenceRoom::create(array_merge($data, [
            'session_code' => $session_code,
            'scheduled_datetime' => $request->start_datetime,
            'status' => 'active',
        ]));

        return response()->json([
            "status" => "success",
            "message" => "Room Successfully Created",
            "conference_session" => $conference_session,
        ]);
    }
}
