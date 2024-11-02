<?php

namespace App\Http\Requests\Guardian;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:guardians,email'],
            'password' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'middlename' => ['required'],
            'phone_number' => ['required', 'integer'],
            'gender' => ['nullable', 'in:Male,Female'],
            'birthdate' => ['nullable'],
            'age' => ['integer'],
            'status' => ['required', 'in:active,inactive'],
            'student_ids' => ['required', 'array'],
        ];
    }
}