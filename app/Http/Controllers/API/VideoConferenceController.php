<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoConference\StoreRequest;
use App\Models\ClassStudent;
use App\Models\JoinedStudent;
use App\Models\Student;
use App\Models\VideoConferenceRoom;
use Carbon\Carbon;
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
            'scheduled_datetime' => Carbon::now(),
            'start_datetime' => Carbon::now(),
            'end_datetime' => Carbon::now()->addHour(),
            'status' => 'active',
        ]));

        return response()->json([
            "status" => "success",
            "message" => "Room Successfully Created",
            "conference_session" => $conference_session,
        ]);
    }

    public function getRecentInstructorClassSessions(Request $request)
    {
        $user = auth()->user();
        if ($user->role != 'instructor')
        {
            return response([
                'message' => 'Invalid User',
            ], 401);
        }

        $conference_sessions = VideoConferenceRoom::where('instructor_id', $user->id)
            ->where('status', 'active')
            ->with('classroom')
            ->get();

        return response()->json([
            'status' => 'success',
            'conference_sessions' => $conference_sessions
        ]);
    }

    public function getStudentClassConferenceSessions(Request $request)
    {
        $class_ids = ClassStudent::where('student_id', $request->student_id)->pluck('class_id')->toArray();
        $conference_sessions = VideoConferenceRoom::whereIn('class_id', $class_ids)->with('instructor', 'classroom', 'joined_students')->get();

        return response()->json([
            'status' => 'success',
            'conference_sessions' => $conference_sessions
        ]);
    }

    public function leaveSession(Request $request)
    {

        $user = auth()->user();

        $session = VideoConferenceRoom::where('session_code', $request->session_code)->first();

        if ($session && $user->role == 'instructor')
        {
            $session->update([
                'status' => 'ended',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Leave Successfully',
            ]);
        }
    }

    public function joinedSession(Request $request) {
        $user = auth()->user();
        $session = VideoConferenceRoom::where('session_code', $request->session_code)->first();

        if($session && $user->role == 'student') {
            $student = Student::where('id', $user->id)->first();

            JoinedStudent::updateOrCreate([
                'session_id' => $session->id,
                'student_id' => $student->id,
            ], [
                'joined_start_time' => Carbon::now(),
                'status' => 'present'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Joined Student Successfully'
            ]);
        }
    }
}
