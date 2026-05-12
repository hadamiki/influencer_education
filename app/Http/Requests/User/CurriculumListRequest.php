<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CurriculumListRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'grade_id' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
            'month' => ['nullable', 'integer', 'between:1,12'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->ajax()) {
            throw new HttpResponseException(
                response()->json([
                    'message' => '検索条件が不正です。',
                    'errors' => $validator->errors(),
                ], 422)
            );
        }

        throw new HttpResponseException(
            redirect()->route('user.show.curriculum', [
                'year' => now()->year,
                'month' => now()->month,
            ])
        );
    }
}