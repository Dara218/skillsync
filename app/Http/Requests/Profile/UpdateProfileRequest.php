<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:' . config('constants.validation.default_max_chars'),
            ],
            // 'email' => [
            //     'required',
            //     'email',
            //     Rule::unique('users')->whereNull('deleted_at')->ignore($userId),
            //     'max:' . config('constants.validation.max_email_address_chars'),
            // ],
            'address' => [
                'max:' . config('constants.validation.max_address_chars'),
            ],
            'tel' => [
                'phone:PH',
            ],
            'birth_date' => [
                'date',
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
            'tel.phone' => __('validation.phone'),
        ];
    }
}
