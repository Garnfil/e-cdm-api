<?php

namespace App\Http\Requests\Admin;

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
            'email' => ['required', 'email', 'unique:admins,email'],
            'password' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'middlename' => ['required'],
            'address' => ['nullable'],
            'contact_no' => ['required', 'integer'],
            'gender' => ['nullable', 'in:Male,Female'],
            'status' => ['required', 'in:active,inactive'],
            'admin_role' => ['required'],
        ];
    }
}
