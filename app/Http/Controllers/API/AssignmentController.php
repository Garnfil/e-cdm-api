<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SchoolWork;
use App\Models\SchoolWorkAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssignmentController extends Controller
{
    public function get()
    {

    }

    public function store(Request $request)
    {
        $schoolWork = SchoolWork::create([
            'class_id' => $request->class_id,
            'instructor_id' => $request->instructor_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        if ($request->has('attachments') && is_array($request->attachments)) {
            foreach ($request->attachments as $key => $attachment) {
                $file_name = null;
                if (! is_string($attachment)) {
                    $file_name = time() . '-' . Str::random(5) . '.' . $attachment->getClientOriginalExtension();
                    $file_path = 'school_works_attachments/';
                    Storage::disk('public')->putFileAs($file_path, $attachment, $file_name);
                }

                SchoolWorkAttachment::create([
                    'school_work_id' => $schoolWork->id,
                    'attachment_name' => is_string($attachment) ? $attachment : $file_name,
                    'school_work_type' => $request->type, // quiz, exams, activities, assignments
                    'attachment_type' => is_string($attachment) ? 'link' : 'file',
                    'status' => 'active',
                ]);
            }
        }
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
