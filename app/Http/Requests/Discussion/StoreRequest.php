<?php

namespace App\Http\Requests\Discussion;

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
            'title' => ['required'],
            'discussion_content' => ['required'],
            'images' => ['nullable', 'array'],
            'user_id' => ['required'],
            'user_type' => ['required'],
            'visibility' => ['required', 'in:public,private'],
            'institute_id' => ['nullable'],
            'course_id' => ['nullable'],
            'section_id' => ['nullable'],
        ];
    }
}
