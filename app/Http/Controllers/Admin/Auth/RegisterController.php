<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.show.top');
        }

        return view('admin.auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'kana' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[ァ-ヶー]+$/u'
                ],
                'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ],
            [
                'name.required' => 'ユーザーネームは必須です',
                'name.string' => 'ユーザーネームは文字列で入力してください',
                'name.max' => 'ユーザーネームは255文字以内で入力してください',

                'kana.required' => 'ユーザーネーム（カナ）は必須です',
                'kana.string' => 'ユーザーネーム（カナ）は文字列で入力してください',
                'kana.max' => 'ユーザーネーム（カナ）は255文字以内で入力してください',
                'kana.regex' => 'ユーザーネーム（カナ）は全角カナで入力してください',

                'email.required' => 'メールアドレスは必須です',
                'email.email' => 'メールアドレス形式で入力してください',
                'email.unique' => 'このメールアドレスは既に登録されています',

                'password.required' => 'パスワードは必須です',
                'password.confirmed' => '確認用パスワードと一致しません',
            ]
        );

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
