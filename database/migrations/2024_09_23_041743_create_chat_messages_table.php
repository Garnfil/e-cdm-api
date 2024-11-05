<?php

use App\Models\Instructor;
use App\Models\Student;
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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->unsignedBigInteger('sender_id');  // Can reference either student or instructor
            $table->enum('sender_type', [Student::class, Instructor::class]);            // To specify the type (Student or Instructor)
            $table->text('content');                  // The message content
            $table->timestamps();

            // Index for sender polymorphic relationship
            $table->index(['sender_id', 'sender_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
