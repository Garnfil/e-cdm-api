<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth-page.admin-login');
    }

    public function saveLogin(Request $request) {}

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login.get')->with('Logout Successfully');
    }
}
