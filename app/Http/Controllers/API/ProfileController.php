<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\AdminUpdateRequest;
use App\Http\Requests\Profile\InstructorUpdateRequest;
use App\Http\Requests\Profile\StudentUpdateRequest;
use App\Models\Admin;
use App\Models\Instructor;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function studentProfile(Request $request, $id)
    {
        $student = Student::find($id);

        return response([
            'status' => 'success',
            'user' => $student,
        ]);
    }

    public function instructorProfile(Request $request, $id)
    {
        $instructor = Instructor::find($id);

        return response([
            'status' => 'success',
            'user' => $instructor,
        ]);
    }

    public function adminProfile(Request $request, $id)
    {
        $admin = Admin::find($id);

        return response([
            'status' => 'success',
            'user' => $admin,
        ]);
    }

    public function updateStudentProfile(StudentUpdateRequest $request)
    {
        try
        {
            $data = $request->except('avatar');
            $student = Student::where('id', $request->id)->first();

            $avatar_path = null;

            if ($request->hasFile('avatar'))
            {
                $attachment = $request->file('avatar');

                $avatar_path = $student->student_id.'_'.Str::random(7).'.'.$attachment->getClientOriginalExtension();

                $file_path = 'students/profiles/';
                Storage::disk('public')->putFileAs($file_path, $attachment, $avatar_path);
            }

            $student->update(array_merge($data, [
                'avatar_path' => $avatar_path,
            ]));

            return response()->json([
                "status" => 'success',
                "message" => "Profile Updated Successfully",
            ]);

        } catch (Exception $exception)
        {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function updateInstructorProfile(InstructorUpdateRequest $request)
    {
        try
        {
            $data = $request->except('avatar');
            $instructor = Instructor::where('id', $request->id)->first();

            $avatar_path = null;

            if ($request->hasFile('avatar'))
            {
                $attachment = $request->file('avatar');

                $avatar_path = Str::random(10).'.'.$attachment->getClientOriginalExtension();

                $file_path = 'instructors/profiles/';
                Storage::disk('public')->putFileAs($file_path, $attachment, $avatar_path);
            }

            $instructor->update(array_merge($data, [
                'avatar' => $avatar_path,
            ]));

            return response()->json([
                "status" => 'success',
                "message" => "Profile Updated Successfully",
            ]);

        } catch (Exception $exception)
        {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function updateAdminProfile(AdminUpdateRequest $request)
    {
        try
        {
            $data = $request->except('avatar');
            $admin = Admin::where('id', $request->id)->first();

            $avatar_path = null;

            if ($request->hasFile('avatar'))
            {
                $attachment = $request->file('attachment');

                $avatar_path = Str::random(10).'.'.$attachment->getClientOriginalExtension();

                $file_path = 'admins/profiles/';
                Storage::disk('public')->putFileAs($file_path, $attachment, $avatar_path);
            }

            $admin->update(array_merge($data, [
                'avatar' => $avatar_path,
            ]));

            return response()->json([
                "status" => 'success',
                "message" => "Profile Updated Successfully",
            ]);

        } catch (Exception $exception)
        {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
