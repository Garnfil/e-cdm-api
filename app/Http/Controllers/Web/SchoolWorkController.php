<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SchoolWork;
use App\Models\SchoolWorkAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolWorkController extends Controller
{
    public function upload(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $school_work = SchoolWork::where('id', $request->school_work_id)->first();
            if (! $school_work)
            {
                throw new Exception('School Work Not Found', 404);
            }

            if ($request->hasFile('attachment') && $request->attachment_type == SchoolWorkAttachment::ATTACHMENT_TYPE_FILE)
            {
                $attachment = $request->file('attachment');

                $path_extension = $attachment->getClientOriginalExtension();

                if (! in_array($path_extension, ['pdf', 'png', 'jpg', 'jpeg', 'webp']))
                {
                    throw new Exception('The requested attachment does not correspond to a recognized file type. The following file types are supported: pdf, png, jpg, jpeg, and webp.', 422);
                }

                $attachment_name = Str::random(7) . '-' . time() . '.' . $attachment->getClientOriginalExtension();

                $file_path = 'school_work_attachments/';
                Storage::disk('public')->putFileAs($file_path, $attachment, $attachment_name);
            } else
            {
                $attachment_name = $request->attachment;
            }

            SchoolWorkAttachment::create([
                'school_work_id' => $school_work->id,
                'attachment_name' => $attachment_name,
                'school_work_type' => $school_work->type,
                'attachment_type' => $request->attachment_type,
                'status' => 'active',
            ]);

            DB::commit();

            return back()->withSuccess('Upload Successfully');

        } catch (Exception $exception)
        {
            DB::rollBack();

            return back()->with('fail', $exception->getMessage());
        }
    }
}
