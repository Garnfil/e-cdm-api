<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionChoice;
use Illuminate\Http\Request;

class QuizQuestionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        // Start a database transaction
        \DB::beginTransaction();
        try {
            // Assuming `quizId` is sent from frontend
            $quiz = Quiz::find($request->quiz_id);

            if (! $quiz) {
                return response()->json(['error' => 'Quiz not found'], 404);
            }

            // Loop through questions and create each one
            foreach ($data['questions'] as $questionData) {
                $question = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['question_text'],
                    'type' => $questionData['type'],
                ]);

                // Loop through choices if the question is multiple-choice or checkbox
                if (in_array($question->type, ['choice', 'checkbox'])) {
                    foreach ($questionData['choices'] as $choiceData) {
                        QuizQuestionChoice::create([
                            'question_id' => $question->id,
                            'choice_text' => $choiceData['choice_text'],
                            'is_correct' => $choiceData['is_correct'] ?? false,
                        ]);
                    }
                }

                // For paragraph type questions (only one choice)
                if ($question->type == 'paragraph') {
                    QuizQuestionChoice::create([
                        'question_id' => $question->id,
                        'choice_text' => $questionData['choices'][0]['choice_text'],
                    ]);
                }
            }

            \DB::commit();

            return response()->json(['success' => 'Quiz saved successfully']);
        } catch (\Exception $e) {
            \DB::rollBack();
            dd($e);

            return response()->json(['error' => 'An error occurred: '.$e->getMessage()], 500);
        }
    }

    public function getQuizQuestions(Request $request, $quiz_id)
    {
        // Get the quiz by ID along with its questions and choices
        $quiz = Quiz::with(['questions.choices'])
            ->where('id', $quiz_id)
            ->first();

        if (! $quiz) {
            return response()->json([
                'error' => 'Quiz not found',
            ], 404);
        }

        // Return the quiz data
        return response()->json([
            'quiz' => [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'description' => $quiz->description,
                'questions' => $quiz->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question_text' => $question->question_text,
                        'type' => $question->type,
                        'choices' => $question->choices->map(function ($choice) {
                            return [
                                'id' => $choice->id,
                                'choice_text' => $choice->choice_text,
                                'is_correct' => $choice->is_correct,
                            ];
                        }),
                    ];
                }),
            ],
        ], 200);
    }
}
