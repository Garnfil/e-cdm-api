<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StudentEmail implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the email ends with 'student.pnm.edu.ph'
        return preg_match('/^[\w\.\-]+@student\.pnm\.edu\.ph$/', $value);
    }

    public function message()
    {
        return 'The email must be a valid student email from the domain student.pnm.edu.ph.';
    }
}
