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
        Schema::create('discussion_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->integer('user_id');
            $table->enum('user_type', ["App\\\\Models\\\\Student", "App\\\\Models\\\\Instructor"]);
            $table->json('images')->nullable();
            $table->enum('visibility', ['public', 'private']);
            $table->foreignId('institute_id')->nullable()->constrained()->onDelete('cascade'); // Restriction to institute
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade'); // Restriction to course
            $table->foreignId('section_id')->nullable()->constrained()->onDelete('cascade'); // Restriction to section
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_posts');
    }
};
