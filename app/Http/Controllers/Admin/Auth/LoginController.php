<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function checkAuthentication(LoginRequest $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
           return redirect()->route('admin.dashboard')->with(['success' => 'تم تسجيل الدخول بنجاح']);
        }
        else
        {
            return redirect()->route('admin.login')->with(['error' => 'هناك خطا فى بيانات الدخول']);
        }
    }
}
