<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'kana' => [
                'required',
                'string',
                'max:255',
                'regex:/^[ァ-ヶー]+$/u',
            ],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
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
        ];
    }
}