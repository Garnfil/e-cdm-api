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
        Schema::create('whiteboard_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_code');
            $table->foreignId('instructor_id')->constrained('instructors')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->text('agora_whiteboard_room_uuid')->nullable();
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->timestamps();
        });

        Schema::create('whiteboard_session_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('whiteboard_id')->constrained('whiteboard_sessions')->cascadeOnDelete();
            $table->string('user_id');
            $table->text('room_token');
            $table->enum('user_type', ['App\Models\Student', 'App\Models\Instructor']);
            $table->enum('user_role', ['admin', 'writer', 'reader']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('whiteboard_session_users');
        Schema::dropIfExists('whiteboard_sessions');
    }
};
