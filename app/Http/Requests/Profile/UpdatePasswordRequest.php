<?php

namespace App\Http\Requests\Profile;

use App\Enums\common\UserGuard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'current_password:' . UserGuard::USER->value,
            ],
            'password' => [
                'required',
                Password::min(config('constants.validation.min_password_chars'))
                    ->letters()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'current_password.current_password' => __('validation.custom.password.incorrect'),
            'password.confirmed' => __('validation.custom.password.not_match'),
        ];
    }
}
