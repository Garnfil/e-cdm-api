<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SchoolWork;
use Illuminate\Http\Request;

class SchoolWorkController extends Controller
{
    public function show(Request $request, $id)
    {
        $school_work = SchoolWork::with('attachments')->find($id);

        switch ($school_work->type) {
            case 'assignment':
                $school_work->load('assignment');
                break;

            case 'activity':
                $school_work->load('activity');
                break;

            case 'quiz':
                $school_work->load('quiz');
                break;

            case 'exam':
                $school_work->load('exam');
                break;
        }

        return response()->json([
            'status' => 'success',
            'school_work' => $school_work,
        ]);

    }
}
