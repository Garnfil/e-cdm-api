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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->nullable(); // This can be either a student or an instructor
            $table->foreignId('receiver_id')->nullable(); // This can also be either
            $table->enum('sender_type', ['student', 'instructor']); // To differentiate sender type
            $table->enum('receiver_type', ['student', 'instructor']); // To differentiate receiver type
            $table->text('message');
            $table->date('message_date');
            $table->timestamps();
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
