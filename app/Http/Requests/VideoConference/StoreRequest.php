<?php

namespace App\Http\Requests\VideoConference;

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
            "class_id" => ['required', 'exists:classes,id'],
            "title" => ['required'],
            "instructor_id" => ['required', 'exists:instructors,id'],
            "description" => ['nullable'],
        ];
    }
}
