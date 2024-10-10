<?php

namespace App\Http\Requests\StudentSubmission;

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
            "school_work_id" => ['required', 'exists:school_works,id'],
            "student_id" => ["required", "exists:students,id"],
            "attachments" => ["nullable", "array"]
        ];
    }
}
