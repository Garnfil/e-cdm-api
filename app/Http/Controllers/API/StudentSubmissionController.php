<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentSubmission\StoreRequest;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionChoice;
use App\Models\QuizStudentAnswer;
use App\Models\SchoolWork;
use App\Models\StudentSubmission;
use App\Models\StudentSubmissionAttachment;
use App\Services\ExceptionHandlerService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentSubmissionController extends Controller
{

    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $schoolWork = SchoolWork::find($request->school_work_id);

            if (! $schoolWork)
                throw new Exception("School Work Not Found", 404);

            $studentSubmission = StudentSubmission::create([
                "school_work_id" => $schoolWork->id,
                "student_id" => $request->student_id,
                "score" => 0,
                "grade" => 0,
                "school_work_type" => $schoolWork->type,
                "datetime_submitted" => Carbon::now(),
            ]);

            if ($request->has('attachments') && is_array($request->attachments)) {
                foreach ($request->attachments as $key => $attachment) {

                    if ($attachment['attachment_type'] == StudentSubmissionAttachment::ATTACHMENT_TYPE_FILE) {
                        $attachment_name = Str::random(7) . '-' . time() . $attachment->getClientOriginalExtension();
                    } else {
                        $attachment_name = $attachment['name'];
                    }

                    $file_path = 'student_submission_attachments/';
                    Storage::disk('public')->putFileAs($file_path, $attachment, $attachment_name);

                    StudentSubmissionAttachment::create([
                        'student_submission_id' => $studentSubmission->id,
                        'attachment_name' => $attachment_name,
                        'attachment_type' => $attachment['attachment_type'],
                        'status' => 'submitted',
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "Submitted Successfully"
            ]);


        } catch (Exception $e) {
            DB::rollBack();
            $exceptionHandlerService = new ExceptionHandlerService();
            return $exceptionHandlerService->__generateExceptionResponse($e);
        }
    }

    public function storeQuizAnswers(Request $request)
    {
        $data = $request->all();
        $quizId = $data['quizId'];
        $studentId = $data['studentId'];
        $answers = $data['answers'];

        // Initialize total score
        $totalScore = 0;
        $totalQuestions = count($answers);

        DB::beginTransaction();
        try {

            $quiz = Quiz::find($quizId);

            if (! $quiz)
                throw new Exception("Quiz Not Found.", 404);

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
            StudentSubmission::create([
                'school_work_id' => $quiz->school_work_id,
                'student_id' => $studentId,
                'score' => $totalScore,
                'grade' => $grade,
                'datetime_submitted' => now(),
            ]);

            DB::commit();

            return response()->json(['success' => 'Quiz submitted successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            $exceptionHandlerService = new ExceptionHandlerService();
            return $exceptionHandlerService->__generateExceptionResponse($e);
        }
    }

    public function gradeStudentSubmission(Request $request)
    {
        $studentSchoolWorkScore = $request->score;
        $student_submission = StudentSubmission::with('school_work')->findOrFail($request->student_submission_id);

        $schoolWorkPoints = $student_submission->school_work->schoolWorkPoints();

        $studentSchoolWorkGrade = ($studentSchoolWorkScore / $schoolWorkPoints->assignment->points) * 100;

        $student_submission->update([
            'score' => $studentSchoolWorkScore,
            'grade' => $studentSchoolWorkGrade
        ]);

        return response()->json([
            'status' => 'success',
            'message' => "School Work Graded Successfully"
        ]);
    }
}
