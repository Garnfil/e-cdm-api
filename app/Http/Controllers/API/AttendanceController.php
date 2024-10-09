<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function get(Request $request)
    {
        $attendances = Attendance::get();

        return response()->json([
            "status" => "success",
            "attendances" => $attendances
        ]);
    }

    public function classAttendance(Request $request)
    {
        $attendances = Attendance::where('class_id', $request->class_id)->get();

        return response()->json([
            "status" => "success",
            "attendances" => $attendances
        ]);
    }

    public function store(Request $request)
    {
        $attendance = Attendance::create($request->all());

        return response()->json([
            "status" => "success",
            "attendance" => $attendance
        ]);
    }

    public function show(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        return response()->json([
            "status" => "success",
            "attendance" => $attendance
        ]);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->update($request->all());

        return response()->json([
            "status" => "success",
            "attendance" => $attendance
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return response()->json([
            "status" => "success",
            "message" => "Attendance Deleted Successfully"
        ]);
    }
}
