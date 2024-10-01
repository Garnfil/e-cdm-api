<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes');
            $table->foreignId('instructor_id')->constrained('instructors');
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['quiz', 'activity', 'assignment', 'exam']);
            $table->enum('status', ['drafted', 'scheduled', 'posted']);
            $table->timestamps();
        });

        Schema::create('school_work_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works');
            $table->string('attachment_name');
            $table->enum('school_work_type', ['quiz', 'activity', 'assignment', 'exam']);
            $table->enum('attachment_type', ['file', 'link']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works');
            $table->text('notes')->nullable();
            $table->string('points');
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->dateTime('due_datetime');
            $table->timestamps();
        });

        Schema::create('student_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments');
            $table->foreignId('student_id')->constrained('students');
            $table->string('score');
            $table->string('grade');
            $table->dateTime('datetime_submitted');
            $table->timestamps();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works');
            $table->text('notes')->nullable();
            $table->string('points');
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->string('quiz_type');
            $table->dateTime('due_datetime');
            $table->timestamps();
        });

        Schema::create('student_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes');
            $table->foreignId('student_id')->constrained('students');
            $table->string('score');
            $table->string('grade');
            $table->dateTime('datetime_submitted');
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works');
            $table->text('notes')->nullable();
            $table->string('points');
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->string('activity_type');
            $table->dateTime('due_datetime');
            $table->timestamps();
        });

        Schema::create('student_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities');
            $table->foreignId('student_id')->constrained('students');
            $table->string('score');
            $table->string('grade');
            $table->dateTime('datetime_submitted');
            $table->timestamps();
        });

        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_work_id')->constrained('school_works');
            $table->text('notes')->nullable();
            $table->string('points');
            $table->enum('assessment_type', ['prelim', 'midterm', 'final']);
            $table->string('exam_type');
            $table->dateTime('due_datetime');
            $table->timestamps();
        });

        Schema::create('student_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams');
            $table->foreignId('student_id')->constrained('students');
            $table->string('score');
            $table->string('grade');
            $table->dateTime('datetime_submitted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_works');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('student_assignments');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('student_quizzes');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('student_activities');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('student_exams');
    }
};
