<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegisterRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.show.top');
        }

        return view('admin.auth.register');
    }

    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();

        $admin = Admin::create([
            'name' => $validated['name'],
            'kana' => $validated['kana'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($admin));

        return redirect()->route('admin.show.login');
    }
}