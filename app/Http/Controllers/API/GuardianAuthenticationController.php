<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GuardianAuth\LoginRequest;
use App\Models\Guardian;
use App\Services\ExceptionHandlerService;
use Exception;
use Illuminate\Support\Facades\Hash;

class GuardianAuthenticationController extends Controller
{
    private $exceptionHandler;

    public function __construct(ExceptionHandlerService $exceptionHandlerService)
    {
        $this->exceptionHandler = $exceptionHandlerService;
    }

    public function login(LoginRequest $request)
    {
        try {
            $guardian = Guardian::where('email', $request->email)->first();

            if (! $guardian) {
                throw new Exception('Guardian Not Found', '404');
            }

            if (! Hash::check($request->password, $guardian->password)) {
                throw new Exception('Invalid Credentials', '400');
            }

            $token = $guardian->createToken('Guardian TOKEN')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $guardian,
            ]);

        } catch (Exception $exception) {
            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }
}
