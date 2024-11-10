<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class InstructorUpdateRequest extends FormRequest
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
            "firstname" => ['required'],
            "lastname" => ['required'],
            "middlename" => ['nullable'],
            "email" => ['required'],
            "username" => ['required'],
            "section" => ['required'],
            "age" => ['nullable', 'numeric'],
            "institute_id" => ['required'],
            "course_id" => ['required'],
        ];
    }
}
