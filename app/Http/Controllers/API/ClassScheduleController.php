<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\ClassStudent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function studentClassesSchedule(Request $request, $student_id)
    {
        $user = Auth::user();

        if (! $user->role == 'student') {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $today = Carbon::today();
        $now = Carbon::now();
        $nextWeek = Carbon::today()->addWeek();

        // Get classes the student is enrolled in
        $classIds = ClassStudent::where('student_id', $student_id)
            ->pluck('class_id');

        // Query date-based schedules
        $dateBasedSchedules = ClassSchedule::whereIn('class_id', $classIds)
            ->where('schedule_date', '>=', $today)
            ->get()
            ->map(function ($schedule) {
                $schedule->start_time = Carbon::parse($schedule->start_time)->format('h:i A');
                $schedule->schedule_date = Carbon::parse($schedule->schedule_date);

                return $schedule;
            });

        // Query day-based schedules
        $dayOfWeekSchedules = ClassSchedule::whereIn('class_id', $classIds)
            ->whereNotNull('days_of_week')
            ->get()
            ->flatMap(function ($schedule) use ($today) {
                $days = json_decode($schedule->days_of_week, true);
                $carbonDays = collect($days)->map(function ($day) {
                    return Carbon::parse($day)->dayOfWeek;
                });

                $upcomingDays = collect();
                for ($i = 0; $i < 7; $i++) {
                    $checkDate = $today->copy()->addDays($i);
                    if ($carbonDays->contains($checkDate->dayOfWeek)) {
                        $upcomingDays->push([
                            'schedule_date' => $checkDate,
                            'start_time' => Carbon::parse($schedule->start_time)->format('h:i A'),
                            'type' => 'Face to Face',
                        ]);
                    }
                }

                return $upcomingDays;
            });

        // Merge and sort
        $schedules = $dateBasedSchedules->merge($dayOfWeekSchedules)->sortBy(['schedule_date', 'start_time']);

        return response()->json([
            'status' => 'success',
            'schedules' => $schedules,
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
