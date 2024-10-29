<?php

namespace App\Http\Requests\Module;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
            'class_id' => 'sometimes|exists:classes,id',
            'instructor_id' => 'sometimes|exists:instructors,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'nullable|in:draft,scheduled,posted',
            'scheduled_datetime' => 'nullable',
        ];
    }
}
