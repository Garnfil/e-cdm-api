<?php

namespace App\Http\Requests\ClassRubric;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "class_id" => ['required'],
            "assessment_type" => ['required'],
            "assignment_percentage" => ['required', 'numeric'],
            "quiz_percentage" => ['required', 'numeric'],
            "activity_percentage" => ['required', 'numeric'],
            "exam_percentage" => ['required', 'numeric'],
            "attendance_percentage" => ['required', 'numeric'],
            "other_performance_percentage" => ['required', 'numeric'],
        ];
    }
}
