<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassRubric;
use App\Models\StudentSchoolWorkGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataReportController extends Controller
{
    public function getTopTenStudentsInAssignment(Request $request, $class_id)
    {
        $rubric = ClassRubric::where('class_id', $class_id)->first();

        if (! $rubric)
        {
            return response()->json([
                'status' => 'failed',
                'message' => 'No Rubric Found'
            ]);
        }

        $students = StudentSchoolWorkGrade::select(DB::raw("(assignment_grade_percentage * {$rubric->assignment_percentage} / 100) as weighted_percentage"))
            ->where('class_id', $class_id)
            ->orderBy('weighted_percentage', 'desc')
            ->get();
    }
}
