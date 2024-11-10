<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            "username" => ['required'],
            "email" => ['required'],
            "password" => ['required'],
            "firstname" => ['required'],
            "lastname" => ['required'],
            "contact_no" => ['required'],
            "address" => ['nullable'],
            "gender" => ['nullable', 'in:Male,Female'],
            "status" => ['required'],
        ];
    }
}
