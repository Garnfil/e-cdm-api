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
        Schema::create('live_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('session_code', 10)->unique();
            $table->datetime('scheduled_datetime');
            $table->foreignId(column: 'class_id')->constrained('classes');
            $table->integer('grace_period')->default(0);
            $table->datetime('start_datetime');
            $table->datetime('end_datetime');
            $table->enum('status', ['active', 'inactive', 'ongoing', 'ended']);
            $table->timestamps();
        });

        Schema::create('joined_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'session_id')->constrained('live_sessions');
            $table->foreignId('student_id')->constrained('students');
            $table->time('joined_start_time');
            $table->enum('status', ['present', 'late']);
            $table->timestamps();
        });

        Schema::create('student_session_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'session_id')->constrained('live_sessions');
            $table->foreignId('joined_student_id')->constrained('joined_students');
            $table->longText('content')->nullable();
            $table->boolean('is_public')->default(0);
            $table->timestamps();
        });

        Schema::create('session_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'session_id')->constrained('live_sessions');
            $table->bigInteger('receiver_id');
            $table->bigInteger(column: 'sender_id');
            $table->longText('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_sessions');
        Schema::dropIfExists('joined_students');
        Schema::dropIfExists('student_session_notes');
        Schema::dropIfExists('session_messages');
    }
};
