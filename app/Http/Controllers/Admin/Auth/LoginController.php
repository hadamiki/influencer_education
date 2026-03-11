<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.show.top');
        }

        return view('admin.auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [
                'email.required' => 'メールアドレスは必須です',
                'email.email' => 'メールアドレス形式で入力してください',
                'password.required' => 'パスワードは必須です',
            ]
        );

        if (Auth::guard('admin')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('admin.show.top');
        }

        return back()
            ->withErrors([
                'email' => 'メールアドレスまたはパスワードが間違っています',
            ])
            ->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.show.login');
    }
}