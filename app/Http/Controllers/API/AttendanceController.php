<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function get(Request $request)
    {
        $attendances = Attendance::get();

        return response()->json([
            'status' => 'success',
            'attendances' => $attendances,
        ]);
    }

    public function classAttendances(Request $request)
    {
        $attendances = Attendance::where('class_id', $request->class_id)->get();

        return response()->json([
            'status' => 'success',
            'attendances' => $attendances,
        ]);
    }

    public function store(Request $request)
    {
        $attendance_code = Str::random(6).'-'.rand(10000, 100000);
        $attendance = Attendance::create(array_merge($request->all(), ['attendance_code' => $attendance_code]));

        return response()->json([
            'status' => 'success',
            'attendance' => $attendance,
        ]);
    }

    public function show(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'attendance' => $attendance,
        ]);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->update($request->all());

        return response()->json([
            'status' => 'success',
            'attendance' => $attendance,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Attendance Deleted Successfully',
        ]);
    }

    public function getClassAttendanceToday($class_id)
    {
        $attendance = Attendance::where('class_id', $class_id)
            ->whereRaw('DATE_ADD(attendance_datetime, INTERVAL grace_period_minute MINUTE) <= ?', [Carbon::now()])
            ->first();

        return response()->json([
            'status' => 'success',
            'attendance' => $attendance,
        ]);
    }
}
