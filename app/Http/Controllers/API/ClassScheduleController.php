<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function get(Request $request)
    {
        $class_schedules = ClassSchedule::get();

        return response()->json([
            'status' => 'success',
            'class_schedules' => $class_schedules,
        ]);
    }

    public function instructorClassesSchedule(Request $request)
    {
        $class_schedules = ClassSchedule::where('instructor_id', $request->instructor_id)
            ->with('class')
            ->get();

        return response()->json([
            'status' => 'success',
            'class_schedules' => $class_schedules,
        ]);
    }

    public function store(Request $request)
    {
        $class_schedule = ClassSchedule::create([
            'instructor_id' => $request->instructor_id,
            'class_id' => $request->class_id,
            'schedule_date' => $request->schedule_date,
            'days_of_week' => $request->has('days_of_week') ? json_encode($request->days_of_week) : json_encode([]),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json([
            'status' => 'success',
            'class_schedule' => $class_schedule,
        ]);
    }
}
