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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string("email");
            $table->string("username");
            $table->string("firstname")->nullable();
            $table->string('lastname')->nullable();
            $table->string('middlename')->nullable();
            $table->integer('age')->nullable();
            $table->foreignId('institute_id')->constrained('institutes');
            $table->foreignId('course_id')->constrained('courses');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
