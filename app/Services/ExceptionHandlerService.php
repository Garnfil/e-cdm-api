<?php

namespace App\Services;

class ExceptionHandlerService
{
    public function __construct() {}

    public function __generateExceptionResponse($exception)
    {
        $exception_code = (int) $exception->getCode();
        $result_code = $exception_code == 0 || is_nan($exception_code) ? 500 : $exception_code;

        return response()->json([
            'status' => 'error',
            'message' => $exception_code == 0 || is_nan($exception_code) ? 'Server Error' : $exception->getMessage(),
        ], $result_code);
    }
}
