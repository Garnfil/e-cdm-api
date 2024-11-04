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

        $now = Carbon::now();
        $nextWeek = Carbon::today()->addWeek();

        // Get classes the student is enrolled in
        $classIds = ClassStudent::where('student_id', $student_id)->pluck('class_id');

        $today = Carbon::now();
        $weekdayNumber = $today->dayOfWeekIso;

        $schedules = ClassSchedule::whereIn('class_id', $classIds)
            ->whereJsonContains('days_of_week', (string) $weekdayNumber)
            ->with('instructor', 'class')
            ->get();

        // // Query date-based schedules
        // $dateBasedSchedules = ClassSchedule::whereIn('class_id', $classIds)
        //     ->where('schedule_date', $today)
        //     ->get();

        // // Query day-based schedules
        // $dayOfWeekSchedules = ClassSchedule::whereIn('class_id', $classIds)
        //     ->whereNotNull('days_of_week')
        //     ->get()
        //     ->flatMap(function ($schedule) use ($today) {
        //         $days = json_decode($schedule->days_of_week, true);
        //         $upcomingDays = collect();

        //         for ($i = 0; $i < 7; $i++) {
        //             $checkDate = $today->copy()->addDays($i);
        //             if (collect($days)->contains($checkDate->dayOfWeek)) {
        //                 $upcomingDays->push((object) [  // Convert each entry to an object
        //                     'schedule_date' => $checkDate->toDateString(),
        //                     'start_time' => Carbon::parse($schedule->start_time)->format('h:i A'),
        //                     'type' => 'Face to Face',
        //                     'class_id' => $schedule->class_id,  // Add other relevant fields if necessary
        //                     'instructor_id' => $schedule->instructor_id,
        //                 ]);
        //             }
        //         }

        //         return $upcomingDays;
        //     });

        // // Merge and sort by schedule_date and start_time
        // $schedules = $dateBasedSchedules->merge($dayOfWeekSchedules)->sortBy([
        //     fn ($a) => $a->schedule_date,
        //     fn ($a) => $a->start_time,
        // ]);

        return response()->json([
            'status' => 'success',
            'schedules' => $schedules, // Convert to zero-based index for JSON response
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
