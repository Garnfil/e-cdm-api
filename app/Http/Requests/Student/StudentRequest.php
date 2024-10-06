<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'student_id' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'nullable|string|min:8',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'year_level' => 'nullable|string|max:255',
            'section' => 'nullable|string|max:255',
            'institute_id' => 'nullable|exists:institutes,id',
            'course_id' => 'nullable|exists:courses,id',
            'age' => 'nullable|integer|min:0',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'current_address' => 'nullable|string|max:255',
            'role' => 'required|string|in:student',
            'status' => 'required|in:active,inactive,blocked,locked,dropped',
        ];
    }
}
