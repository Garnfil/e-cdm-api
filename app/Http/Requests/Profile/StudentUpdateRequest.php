<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            "student_id" => ['required'],
            "year_level" => ['required'],
            "section" => ['required'],
            "institute_id" => ['required'],
            "course_id" => ['required'],
            "birthdate" => ['nullable'],
            "age" => ['nullable', 'numeric'],
            "gender" => ['nullable', 'in:Male,Female'],
            "current_address" => ['nullable'],
            "avatar" => ["nullable", "image"]
        ];
    }
}
