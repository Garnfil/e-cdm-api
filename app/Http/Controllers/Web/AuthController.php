<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth-page.admin-login');
    }

    public function saveLogin(Request $request)
    {
        try {
            $request->validate([
                'email_username' => 'required',
                'password' => 'required',
            ]);

            $login_type = filter_var($request->email_username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $admin = Admin::where($login_type, $request->email_username)->firstOrFail();

            if (! Hash::check($request->password, $admin->password)) {
                throw new Exception('Invalid Credentials', '400');
            }

            Auth::login($admin);

            return redirect()->route('admin.dashboard')->withSuccess('Admin Login Successfully');

        } catch (Exception $exception) {
            return back()->with('fail', $exception->getMessage());
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login.get')->with('Logout Successfully');
    }
}
