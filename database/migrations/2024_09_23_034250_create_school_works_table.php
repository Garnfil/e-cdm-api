<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('rubrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->integer('assignment_percentage'); // percentage for assignments
            $table->integer('quiz_percentage');       // percentage for quizzes
            $table->integer('exam_percentage');       // percentage for exams
            $table->integer('activity_percentage');   // percentage for activities
            $table->integer('attendance_percentage'); // percentage for attendance
            $table->integer('other_performance_percentage')->default(0); // percentage for other performance
            $table->timestamps();
        });

        Schema::create('school_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('instructors');
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['quiz', 'activity', 'assignment', 'exam']);
            $table->enum('status', ['drafted', 'scheduled', 'posted']);
            $table->dateTime('due_datetime');
            $table->timestamps();
        });

        Schema::create('class_school_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('school_work_id')->constrained('instructors')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('school_work_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works')->cascadeOnDelete();
            $table->string('attachment_name');
            $table->enum('school_work_type', ['quiz', 'activity', 'assignment', 'exam']);
            $table->enum('attachment_type', ['file', 'link']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('student_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('score')->default(0);
            $table->string('grade')->default('passed');
            $table->enum('school_work_type', ['quiz', 'activity', 'assignment', 'exam']);
            $table->dateTime('datetime_submitted')->nullable();
            $table->timestamps();
        });

        Schema::create('student_submission_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_submission_id')->constrained('student_submissions')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->text('attachment_name');
            $table->enum('attachment_type', ['file', 'link']);
            $table->enum('status', ['drafted', 'submitted']);
            $table->timestamps();
        });

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->string('points');
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->timestamps();
        });

        Schema::create('student_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('score')->default(0);
            $table->double('grade', 10, 2)->default(0);
            $table->dateTime('datetime_submitted');
            $table->timestamps();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->string('points');
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->string('quiz_type');
            $table->boolean('has_quiz_form')->default(0);
            $table->timestamps();
        });

        Schema::create('student_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('score')->default(0);
            $table->double('grade', 10, 2)->default(0);
            $table->dateTime('datetime_submitted');
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->string('points');
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->string('activity_type');
            $table->timestamps();
        });

        Schema::create('student_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('score')->default(0);
            $table->double('grade', 10, 2)->default(0);
            $table->dateTime('datetime_submitted');
            $table->timestamps();
        });

        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->string('points');
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->string('exam_type');
            $table->timestamps();
        });

        Schema::create('student_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('score')->default(0);
            $table->double('grade', 10, 2)->default(0);
            $table->dateTime('datetime_submitted');
            $table->timestamps();
        });

        Schema::create('student_school_works_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('graded_by')->nullable()->constrained('instructors')->nullOnDelete();
            $table->enum('assessment_category', ['prelim', 'midterm', 'finals']);
            $table->double('assignment_grade_percentage', 10, 2)->default(0);
            $table->double('activities_grade_percentage', 10, 2)->default(0);
            $table->double('quizzes_grade_percentage', 10, 2)->default(0);
            $table->double('exams_grade_percentage', 10, 2)->default(0);
            $table->double('attendance_grade_percentage', 10, 2)->default(0);
            $table->double('other_performances_grade_percentage', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('student_final_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_school_works_grade_id')->constrained('student_school_works_grades')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->float('final_grade'); // final grade for this assessment
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('rubrics');
        Schema::dropIfExists('school_works');
        Schema::dropIfExists('school_work_attachments');
        Schema::dropIfExists('student_submissions');
        Schema::dropIfExists('student_submission_attachments');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('student_assignments');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('student_quizzes');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('student_activities');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('student_exams');
        Schema::dropIfExists('student_school_works_grades');
        Schema::dropIfExists('student_final_grades');
    }
};
