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
        Schema::create('discussion_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->nullable()->constrained('discussion_posts')->onDelete('cascade');
            $table->foreignId('comment_id')->nullable()->constrained('discussion_comments')->onDelete('cascade');
            $table->bigInteger('user_id');
            $table->enum('user_type', ["App\\\\Models\\\\Student", "App\\\\Models\\\\Instructor"]);
            $table->enum('vote_type', allowed: ['upvote', 'downvote']); // Upvote or Downvote
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_votes');
    }
};
