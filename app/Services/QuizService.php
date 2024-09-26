<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\SchoolWork;
use App\Models\SchoolWorkAttachment;
use DB;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuizService
{
    public function __construct() {}

    public function createAndUpload($request)
    {
        try {
            DB::beginTransaction();

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
                        $file_name = time().'-'.Str::random(5).'.'.$attachment->getClientOriginalExtension();
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

            $quiz = Quiz::create([
                'school_work_id' => $schoolWork->id,
                'notes' => $request->notes,
                'points' => $request->points,
                'assessment_type' => 'prelim',
                'quiz_type' => 'normal',
                'due_datetime' => $request->datetime,
            ]);

            DB::commit();

            return [
                'schoolWork' => $schoolWork,
                'quiz' => $quiz,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request)
    {
        try {

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
