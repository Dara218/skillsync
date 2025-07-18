<?php

namespace App\Http\Requests\User;

use App\Enums\common\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:' . config('constants.validation.default_max_chars'),
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users')->whereNull('deleted_at'),
                'max:' . config('constants.validation.max_email_address_chars'),
            ],
            'username' => [
                'required',
                Rule::unique('users')->whereNull('deleted_at'),
                'max:' . config('constants.validation.max_username_chars'),
            ],
            'password' => [
                'required',
                Password::min(config('constants.validation.min_password_chars'))
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'role' => [
                'required',
                Rule::in(UserRole::list()),
            ],
        ];
    }
}
