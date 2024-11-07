<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SchoolEvent;
use Illuminate\Http\Request;

class SchoolEventController extends Controller
{
    public function getAll(Request $request)
    {
        $events = SchoolEvent::get();

        return response()->json([
            'status' => 'success',
            'events' => $events,
        ]);
    }
}
