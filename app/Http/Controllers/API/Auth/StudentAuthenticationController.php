<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StudentAuth\LoginRequest;
use App\Http\Requests\Auth\StudentAuth\RegisterRequest;
use App\Models\Student;
use App\Services\ExceptionHandlerService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentAuthenticationController extends Controller
{
    private $exceptionHandler;

    public function __construct(ExceptionHandlerService $exceptionHandlerService)
    {
        $this->exceptionHandler = $exceptionHandlerService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            // Check if the student id was already exist.
            $existing_student = Student::where('student_id', $request->student_id)->exists();
            if ($existing_student) {
                throw new Exception('The Student ID was already exists', 422);
            }

            $student = Student::create(array_merge($data, ['password' => Hash::make($request->password)]));

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'The Registration is successfully submitted.',
            ]);

        } catch (Exception $exception) {
            DB::rollBack();

            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $student = Student::where('email', $request->email)
                ->where('student_id', $request->student_id)->firstOrFail();

            if (! Hash::check($request->password, $student->password)) {
                throw new Exception('Invalid Credentials', '400');
            }

            $token = $student->createToken('STUDENT TOKEN')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $student,
            ]);

        } catch (Exception $exception) {
            dd($exception);

            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }
}
