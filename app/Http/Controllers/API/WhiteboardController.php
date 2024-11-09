<?php

namespace App\Http\Controllers\API;

use App\Events\WhiteboardUpdated;
use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\WhiteboardSession;
use App\Models\WhiteboardSessionUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

// require_once("/app/netless-token/php");

class WhiteboardController extends Controller
{

    public function getUserWhiteboardSession(Request $request, $session_code)
    {
        $user = auth()->user();
        $user_type = $user->type == "student" ? "App\Models\Student" : "App\Models\Instructor";
        $whiteboard = WhiteboardSession::where('session_code', $session_code)
            ->first();

        if (! $whiteboard)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Whiteboard Not Found',
            ], 404);
        }

        $whiteboard_user = WhiteboardSessionUser::where('whiteboard_id', $whiteboard->id)
            ->where('user_id', $user->id)
            ->where('user_type', $user_type)->first();

        return response()->json([
            'status' => 'success',
            'whiteboard' => $whiteboard,
            'whiteboard_user' => $whiteboard_user,
        ]);
    }

    public function generateRoom(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $session_code = Str::random(10);

            $session = WhiteboardSession::create([
                'session_code' => $session_code,
                'class_id' => $request->class_id,
                'instructor_id' => $request->instructor_id,
            ]);

            $response = Http::withHeaders([
                'token' => "NETLESSSDK_YWs9dUVpaG50RTVNbldaWG9kZyZub25jZT0wNThjNzM1MC05ZThlLTExZWYtYjZiYy00Zjk0YjFkODY3ZGMmcm9sZT0wJnNpZz04OTNlOTk3NzBiMTlhZjBjODlmOGM4MmZmZGUxZTFmZjgyMWJjODdlMWQyZGI4YmY0N2NlMzMxYWM2NDNjNzQ2",
                'region' => 'sg',
                'Content-Type' => 'application/json',
            ])->post('https://api.netless.link/v5/rooms', [
                        'isRecord' => false,
                    ]);

            // Check response status and get response data
            if ($response->successful())
            {
                $data = $response->json();

                $session->update([
                    'agora_whiteboard_room_uuid' => $data['uuid'],
                ]);

                $room_token = $this->generateRoomToken($data['uuid']);

                WhiteboardSessionUser::create([
                    'whiteboard_id' => $session->id,
                    'user_id' => $request->instructor_id,
                    'room_token' => $room_token,
                    'user_type' => 'App\Models\Instructor',
                    'user_role' => 'admin',
                ]);

                return response()->json([
                    'status' => 'success',
                    'conference_session' => $session,
                    'room_uuid' => $session->agora_whiteboard_room_uuid,
                    'room_token' => $room_token,
                ]);
                // Process the response data as needed
            } else
            {
                // Handle errors
                $error = $response->body();
                throw new Exception("Failed to  Create Room");
            }

        } catch (Exception $exception)
        {
            DB::rollBack();
            return response()->json([
                'error' => $exception,
            ], 400);
        }

    }

    public function joinWhiteboardSession(Request $request)
    {
        $user = auth()->user();
        $user_type = $user->type == "student" ? "App\Models\Student" : "App\Models\Instructor";
        $whiteboard_session_code = $request->session_code;
        $whiteboard = WhiteboardSession::where('session-code', $whiteboard_session_code)->first();

        if (! $whiteboard)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Whiteboard Not Found',
            ], 404);
        }

        $room_token = $this->generateRoomToken($whiteboard->agora_whiteboard_room_uuid, $role = 'writer');

        $whiteboard_user = WhiteboardSessionUser::create([
            'whiteboard_id' => $whiteboard->id,
            'user_id' => $user->id,
            'user_type' => $user_type,
            'room_token' => $room_token,
        ]);

        return response()->json([
            'whiteboard' => $whiteboard,
            'whiteboard_user' => $whiteboard_user,
        ]);


    }

    public function generateRoomToken($room_uuid, $role = 'admin')
    {
        $roomUUID = $room_uuid; // Replace with the actual Room UUID
        $token = "NETLESSSDK_YWs9dUVpaG50RTVNbldaWG9kZyZub25jZT0wNThjNzM1MC05ZThlLTExZWYtYjZiYy00Zjk0YjFkODY3ZGMmcm9sZT0wJnNpZz04OTNlOTk3NzBiMTlhZjBjODlmOGM4MmZmZGUxZTFmZjgyMWJjODdlMWQyZGI4YmY0N2NlMzMxYWM2NDNjNzQ2";

        $response = Http::withHeaders([
            'token' => $token,
            'Content-Type' => 'application/json',
            'region' => 'sg',
        ])->post("https://api.netless.link/v5/tokens/rooms/{$roomUUID}", [
                    'lifespan' => 3600000,
                    'role' => $role,
                ]);

        // Check the response and output
        if ($response->successful())
        {
            $data = $response->json();
            return $data;
        } else
        {
            // Handle errors
            echo "Error: " . $response->body();
        }
    }

    public function update(Request $request, $sessionId)
    {

        // Broadcast the data to the session's Pusher channel
        $data = $request->all();
        event(new WhiteboardUpdated($data, $sessionId));

        return response()->json(['status' => 'Whiteboard updated', 'data' => $data]);
    }
}
