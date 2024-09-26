<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\StoreRequest;
use App\Services\ExceptionHandlerService;
use App\Services\QuizService;
use Exception;

class QuizController extends Controller
{
    private $exceptionHandler;

    private $quizService;

    public function __construct(ExceptionHandlerService $exceptionHandler, QuizService $quizService)
    {
        $this->exceptionHandler = $exceptionHandler;
        $this->quizService = $quizService;
    }

    public function getAll() {}

    public function get() {}

    public function store(StoreRequest $request)
    {
        try {
            $result = $this->quizService->createAndUpload($request);

            return response()->json([
                'status' => 'success',
                'schoolWork' => $result['schoolWork'],
            ]);

        } catch (Exception $exception) {
            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }

    public function update()
    {
        try {

        } catch (Exception $exception) {

        }
    }

    public function destroy() {}
}
