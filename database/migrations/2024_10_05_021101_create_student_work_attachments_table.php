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
        // Schema::create('student_assignment_attachments', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('student_assignment_id')->constrained('student_assignments')->cascadeOnDelete();
        //     $table->string('attachment_name');
        //     $table->enum('attachment_type', ['file', 'link']);
        //     $table->enum('status', ['drafted', 'submitted']);
        //     $table->timestamps();
        // });

        // Schema::create('student_activity_attachments', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('student_activity_id')->constrained('student_activities')->cascadeOnDelete();
        //     $table->string('attachment_name');
        //     $table->enum('attachment_type', ['file', 'link']);
        //     $table->enum('status', ['drafted', 'submitted']);
        //     $table->timestamps();
        // });

        // Schema::create('student_quiz_attachments', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('student_quiz_id')->constrained('student_quizzes')->cascadeOnDelete();
        //     $table->string('attachment_name');
        //     $table->enum('attachment_type', ['file', 'link']);
        //     $table->enum('status', ['drafted', 'submitted']);
        //     $table->timestamps();
        // });

        // Schema::create('student_exam_attachments', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('student_exam_id')->constrained('student_exams')->cascadeOnDelete();
        //     $table->string('attachment_name');
        //     $table->enum('attachment_type', ['file', 'link']);
        //     $table->enum('status', ['drafted', 'submitted']);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('student_work_attachments');
    }
};
