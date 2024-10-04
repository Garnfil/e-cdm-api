<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\StoreRequest;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionChoice;
use App\Services\ExceptionHandlerService;
use App\Services\QuizService;
use Exception;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $exceptionHandler;

    private $quizService;

    public function __construct(ExceptionHandlerService $exceptionHandler, QuizService $quizService)
    {
        $this->exceptionHandler = $exceptionHandler;
        $this->quizService = $quizService;
    }

    public function getAll()
    {
        $quizzes = Quiz::with('school_work')->get();

        return response()->json([
            'status' => 'success',
            'quizzes' => $quizzes,
        ]);
    }

    public function get()
    {
        $quizzes = Quiz::with('school_work')->get();

        return response()->json([
            'status' => 'success',
            'quizzes' => $quizzes,
        ]);
    }

    public function show(Request $request, $id)
    {
        $quiz = Quiz::with('school_work')->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'quiz' => $quiz,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $result = $this->quizService->createAndUpload($request);

            return response()->json([
                'status' => 'success',
                'quiz' => $result['quiz']->load('school_work'),
            ]);

        } catch (Exception $exception) {
            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }

    public function storeQuizForm(Request $request)
    {
        $data = $request->all();

        // Start a database transaction
        \DB::beginTransaction();
        try {
            // Assuming `quizId` is sent from frontend
            $quiz = Quiz::find($data['quizId']);

            if (! $quiz) {
                return response()->json(['error' => 'Quiz not found'], 404);
            }

            foreach ($data['questions'] as $questionData) {
                // Create quiz question
                $question = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['questionText'],
                    'type' => $questionData['type'],
                ]);

                // Store choices if the question type is "choice"
                if ($questionData['type'] === 'choice') {
                    foreach ($questionData['choices'] as $choiceData) {
                        QuizQuestionChoice::create([
                            'question_id' => $question->id,
                            'choice_text' => $choiceData['text'],
                            'is_correct' => $choiceData['isCorrect'],
                        ]);
                    }
                }
            }

            \DB::commit();

            return response()->json(['success' => 'Quiz saved successfully']);
        } catch (Exception $e) {
            \DB::rollBack();

            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function update()
    {
        try {

        } catch (Exception $exception) {

        }
    }

    public function destroy()
    {
    }
}
