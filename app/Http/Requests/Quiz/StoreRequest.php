<?php

namespace App\Http\Requests\Quiz;

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
            'class_id' => ['required', 'exists:classes,id'],
            'instructor_id' => ['required', 'exists:instructors,id'],
            'title' => ['required'],
            'description' => ['required'],
            'type' => ['required', 'in:quiz,activity,assignment,exam'],
            'status' => ['nullable', 'in:drafted,scheduled,posted'],
            'attachments' => ['nullable', 'array'],
            'notes' => ['nullable'],
            'points' => ['required'],
            'assessment_type' => ['nullable'],
            'quiz_type' => ['nullable'],
            'due_datetime' => ['required'],
        ];
    }
}
