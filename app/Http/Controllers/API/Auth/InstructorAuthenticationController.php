<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\InstructorAuth\LoginRequest;
use App\Models\Instructor;
use App\Services\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstructorAuthenticationController extends Controller
{
    private $exceptionHandler;

    public function __construct(ExceptionHandlerService $exceptionHandlerService)
    {
        $this->exceptionHandler = $exceptionHandlerService;
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            $instructor = Instructor::create(array_merge($data, ['password' => Hash::make($request->password)]));

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
            $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $instructor = Instructor::where($login_type, $request->login)->firstOrFail();

            if (! Hash::check($request->password, $instructor->password)) {
                throw new Exception('Invalid Credentials', '400');
            }

            $token = $instructor->createToken('INSTRUCTOR TOKEN')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $instructor,
            ]);

        } catch (Exception $exception) {
            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }
}
