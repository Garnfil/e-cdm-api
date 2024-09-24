<?php

namespace App\Http\Requests\Auth\StudentAuth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "firstname" => ['required', 'min:3'],
            "lastname" => ['required', 'min:3'],
            "middlename" => ['required', 'min:3'],
            "student_id" => ['required'],
            "email" => ['required', 'email'],
            "password" => ['required', 'min:8'],
        ];
    }
}
