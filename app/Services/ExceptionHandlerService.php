<?php

namespace App\Services;

class ExceptionHandlerService
{
    public function __construct()
    {
    }

    public function __generateExceptionResponse($exception)
    {
        // $exception_code = $exception->getCode();
        // $result_code = 500;

        // if ($exception_code != 0) {
        //     $result_code = $exception_code;
        // }

        // if (is_numeric($exception_code)) {
        //     $result_code = $exception_code;
        // }

        // if ($result_code == 500) {
        //     return response()->json($exception, 500);
        // }

        return response()->json([
            'status' => 'error',
            'message' => $exception->getMessage(),
        ], 400);
    }
}
