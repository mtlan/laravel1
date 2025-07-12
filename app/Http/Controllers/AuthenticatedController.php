<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{
    public function view()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Hãy nhập địa chỉ email!',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'password.required' => 'Hãy nhập mật khẩu',
        ]);

        //$user = Auth::user();

        $email = $request->get('email');
        $password = $request->get('password');

        if (Auth::attempt(['email' => $email, 'password' => $password]) == true) {
            session()->flash('user_message', 'Chào mừng ' . Auth::user()->name . ' đã quay trở lại. Cần hỗ trợ gì cứ nhắn tin cho shop nhé!!');

            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('portal.dashboard');
            }

            return redirect()->route('home');
        }

        return redirect()->back()->withInput(['email' => $email])->withErrors(['login_error' => 'Địa chỉ email hoặc mật khẩu không đúng, vui lòng thử lại!!']);
    }

    public function destroy()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
