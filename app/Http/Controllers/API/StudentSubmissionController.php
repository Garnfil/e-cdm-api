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
use App\Services\GradeService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentSubmissionController extends Controller
{
    public function schoolWorkStudentSubmissions(Request $request, $school_work_id)
    {
        $studentSubmissions = StudentSubmission::where('school_work_id', $school_work_id)
            ->latest()
            ->with('attachments', 'student')
            ->get();

        return response()->json([
            'status' => 'success',
            'student_submissions' => $studentSubmissions,
        ]);
    }

    public function classStudentSubmission(Request $request)
    {
        $studentSubmission = StudentSubmission::where('student_id', operator: $request->student_id)
            ->where('school_work_id', $request->school_work_id)->with('attachments')->first();

        return response()->json([
            'status' => 'success',
            'student_submission' => $studentSubmission,
        ]);
    }

    public function show(Request $request, $submission_id)
    {
        $studentSubmission = StudentSubmission::where('id', $submission_id)
            ->latest()
            ->with(['attachments', 'student', 'school_work'])
            ->first();

        $studentSubmission->school_work->points = $studentSubmission->school_work->schoolWorkPoints();

        return response()->json([
            'status' => 'success',
            'student_submission' => $studentSubmission,
        ]);
    }

    public function storeWithGrade(Request $request, $school_work_type)
    {
        $request_type = $request->school_work_type;
        $student_id = $request->student_id;
        $class_id = $request->class_id;

        if ($request->has('submissions') && is_array($request->submissions))
        {
            // Collect all school_work_ids from submissions for a batch query
            $school_work_ids = collect($request->submissions)->pluck('school_work_id')->all();

            // Fetch all existing submissions for the student and these school works in one query
            $existingSubmissions = StudentSubmission::where('student_id', $student_id)
                ->whereIn('school_work_id', $school_work_ids)
                ->get()
                ->keyBy('school_work_id');

            foreach ($request->submissions as $submissionData)
            {
                $school_work_id = $submissionData['school_work_id'];
                $score = $submissionData['score'];

                // Check if a submission already exists
                $submission = $existingSubmissions->get($school_work_id);

                // Update or create submission based on existence
                if ($submission)
                {
                    $submission->update(['score' => $score]);
                } elseif ($score > 0)
                {  // Only create if score > 0
                    StudentSubmission::create([
                        'school_work_id' => $school_work_id,
                        'score' => $score,
                        'student_id' => $student_id,
                        'school_work_type' => $request_type,
                    ]);
                }
            }
        }

        $gradeService = new GradeService;
        $gradeService->computeClassStudentGrade($request->school_work_type, $student_id, $class_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Submitted Successfully',
        ]);
    }

    public function store(StoreRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $schoolWork = SchoolWork::find($request->school_work_id);

            if (! $schoolWork)
            {
                throw new Exception('School Work Not Found', 404);
            }

            $studentSubmission = StudentSubmission::updateOrCreate([
                'school_work_id' => $schoolWork->id,
                'student_id' => $request->student_id,
                'school_work_type' => $schoolWork->type,
            ], [
                'score' => 0,
                'grade' => 0,
                'datetime_submitted' => Carbon::now(),
            ]);

            if ($request->has('attachments') && is_array($request->attachments))
            {
                foreach ($request->attachments as $key => $attachment)
                {
                    $attachment_name = $attachment['attachment'];

                    if ($attachment['attachment_type'] == StudentSubmissionAttachment::ATTACHMENT_TYPE_FILE)
                    {

                        $path_extension = $attachment['attachment']->getClientOriginalExtension();

                        if (! in_array($path_extension, ['pdf', 'png', 'jpg', 'jpeg', 'webp']))
                        {
                            throw new Exception('The requested attachment does not correspond to a recognized file type. The following file types are supported: pdf, png, jpg, jpeg, and webp.', 422);
                        }

                        $attachment_name = Str::random(7) . '-' . time() . '.' . $path_extension;

                        $file_path = 'student_submission_attachments/';
                        Storage::disk('public')->putFileAs($file_path, $attachment['attachment'], $attachment_name);
                    }

                    StudentSubmissionAttachment::create([
                        'student_submission_id' => $studentSubmission->id,
                        'student_id' => $request->student_id,
                        'attachment_name' => $attachment_name,
                        'attachment_type' => $attachment['attachment_type'],
                        'status' => 'submitted',
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Submitted Successfully',
            ]);

        } catch (Exception $e)
        {
            DB::rollBack();

            // return response($e, 400);
            $exceptionHandlerService = new ExceptionHandlerService;

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
        try
        {

            $quiz = Quiz::find($quizId);

            if (! $quiz)
            {
                throw new Exception('Quiz Not Found.', 404);
            }

            foreach ($answers as $questionId => $answer)
            {
                $question = QuizQuestion::find($questionId);

                // For multiple choice questions
                if ($question->type === 'choice')
                {
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
                    if ($isCorrect)
                    {
                        $totalScore += 1;
                    }
                }

                // For paragraph questions (manual grading might be needed)
                if ($question->type === 'paragraph')
                {
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
        } catch (Exception $e)
        {
            DB::rollBack();
            $exceptionHandlerService = new ExceptionHandlerService;

            return $exceptionHandlerService->__generateExceptionResponse($e);
        }
    }

    public function gradeStudentSubmission(Request $request)
    {
        try
        {
            /**
             * Request Inputs: score, student_submission_id
             */
            $studentSchoolWorkScore = $request->score;
            $submissionId = $request->student_submission_id ?? $request->submission_id;

            $student_submission = StudentSubmission::with('school_work')->find($submissionId);

            $schoolWorkPoints = $student_submission->school_work->schoolWorkPoints();

            $studentSchoolWorkGrade = ($studentSchoolWorkScore / $schoolWorkPoints) * 100;

            $student_submission->update([
                'score' => $studentSchoolWorkScore,
                'grade' => $studentSchoolWorkGrade,
            ]);

            $gradeService = new GradeService;
            $gradeService->computeClassStudentGrade($student_submission->school_work_type, $student_submission->student_id, $student_submission->school_work->class_id);

            return response()->json([
                'status' => 'success',
                'message' => 'School Work Graded Successfully',
            ]);
        } catch (Exception $e)
        {
            DB::rollBack();
            $exceptionHandlerService = new ExceptionHandlerService;

            return $exceptionHandlerService->__generateExceptionResponse($e);
        }
    }
}
