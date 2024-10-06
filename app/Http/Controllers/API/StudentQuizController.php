<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionChoice;
use App\Models\QuizStudentAnswer;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;

class StudentQuizController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $quizId = $data['quizId'];
        $studentId = $data['studentId'];
        $answers = $data['answers'];

        // Initialize total score
        $totalScore = 0;
        $totalQuestions = count($answers);

        \DB::beginTransaction();
        try {
            foreach ($answers as $questionId => $answer) {
                $question = QuizQuestion::find($questionId);

                // For multiple choice questions
                if ($question->type === 'choice') {
                    $choice = QuizQuestionChoice::find($answer);
                    $isCorrect = $choice->is_correct;

                    // Store student answer
                    QuizStudentAnswer::create([
                        'quiz_id' => $quizId,
                        'student_id' => $studentId,
                        'question_id' => $questionId,
                        'answer_text' => $choice->choice_text,
                        'is_correct' => $isCorrect,
                    ]);

                    // Increment score if the answer is correct
                    if ($isCorrect) {
                        $totalScore += 1;
                    }
                }

                // For paragraph questions (manual grading might be needed)
                if ($question->type === 'paragraph') {
                    QuizStudentAnswer::create([
                        'quiz_id' => $quizId,
                        'student_id' => $studentId,
                        'question_id' => $questionId,
                        'answer_text' => $answer,
                        'is_correct' => false, // Default to false, needs manual grading
                    ]);
                }
            }

            // Calculate the grade as a percentage
            $grade = ($totalScore / $totalQuestions) * 100;

            // Store the student's total score and grade
            StudentQuiz::create([
                'quiz_id' => $quizId,
                'student_id' => $studentId,
                'score' => $totalScore,
                'grade' => $grade,
                'datetime_submitted' => now(),
            ]);

            \DB::commit();

            return response()->json(['success' => 'Quiz submitted successfully']);
        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json(['error' => 'An error occurred: '.$e->getMessage()], 500);
        }
    }
}
