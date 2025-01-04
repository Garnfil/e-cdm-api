<?php

namespace App\Http\Requests\Student;

use App\Rules\StudentEmail;
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
            "student_id" => ['required', 'unique:students,student_id'],
            "email" => ['required', new StudentEmail()],
            "password" => ['required'],
            "firstname" => ['required'],
            "lastname" => ['required'],
            "middlename" => ['nullable'],
            "year_level" => ['nullable'],
            "section" => ['nullable'],
            "institute_id" => ['nullable'],
            "course_id" => ['nullable'],
            "age" => ['nullable'],
            "birthdate" => ['nullable'],
            "gender" => ['nullable'],
            "current_address" => ['nullable'],
            "avatar_path" => ['nullable'],
        ];
    }


}
