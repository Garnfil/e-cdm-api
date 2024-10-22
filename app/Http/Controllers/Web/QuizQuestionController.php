<?php

namespace App\Http\Controllers\Web;

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

            if (empty($data['questions']) || ! isset($data['questions'])) {
                $quiz->questions()->delete();

                return back()->withSuccess('Quiz Questions Updated Successfully');
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

            return back()->withSuccess('Quiz Questions Added Successfully');
        } catch (\Exception $e) {
            \DB::rollBack();
            dd($e);

            return response()->json(['error' => 'An error occurred: '.$e->getMessage()], 500);
        }
    }
}
