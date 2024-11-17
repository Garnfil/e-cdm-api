<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentInfoRequest extends FormRequest
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
            'year_level' => ['required'],
            'section_id' => ['required'],
            'birthdate' => ['required'],
            'guardian_firstname' => ['required'],
            'guardian_lastname' => ['required'],
            'guardian_email' => ['required', 'email'],
            'guardian_contactno' => ['required', 'max:10', 'min:10'],
        ];
    }
}
