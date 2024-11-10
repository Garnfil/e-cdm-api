<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\AdminUpdateRequest;
use App\Http\Requests\Profile\ChangeUserPasswordRequest;
use App\Models\Admin;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\VideoConferenceRoom;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $total_students = Student::count();
        $total_instructors = Instructor::count();
        $recent_conference_sessions = VideoConferenceRoom::with('classroom')->latest('end_datetime')->limit(5)->get();
        return view('welcome', compact('total_students', 'total_instructors', 'recent_conference_sessions'));
    }

    public function profile(Request $request)
    {

        return view('admin-page.profile.profile');
    }

    public function updateAdminProfile(AdminUpdateRequest $request)
    {
        try
        {
            $data = $request->except('avatar');

            $admin = Admin::where('id', $request->id)->first();

            $admin->update($data);

            $avatar_path = null;

            if ($request->hasFile('avatar'))
            {
                $attachment = $request->file('avatar');

                $avatar_path = Str::random(10) . '.' . $attachment->getClientOriginalExtension();

                $file_path = 'admins/profiles/';
                Storage::disk('public')->putFileAs($file_path, $attachment, $avatar_path);

                $admin->update([
                    'avatar' => $avatar_path,
                ]);
            }

            return back()->with('success', "Profile Updated Successfully");


        } catch (Exception $exception)
        {
            dd($exception);
            return back()->with('fail', $exception->getMessage());
        }
    }

    public function changePassword(ChangeUserPasswordRequest $request)
    {
        $user = auth()->user();

        if (! Hash::check($request->old_password, $user->password))
            return back()->with('fail', 'Your old password is incorrect. Please Try Again.');

        $new_password = Hash::make($request->new_password);

        $update_user = $user->update([
            'password' => $new_password,
        ]);

        if ($update_user)
        {
            return back()->withSuccess('Your Password Updated Successfully.');
        }
    }


}
