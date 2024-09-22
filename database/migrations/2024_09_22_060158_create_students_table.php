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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("student_id");
            $table->string("email")->unique();
            $table->string("password");
            $table->string("firstname");
            $table->string("middlename");
            $table->string("lastname");
            $table->string("year_level")->nullable();
            $table->string("section")->nullable();
            $table->integer("age")->nullable();
            $table->date("birthdate")->nullable();
            $table->string("gender")->nullable();
            $table->string("current_address")->nullable();
            $table->string("avatar_path");
            $table->enum("status", ["active", "inactive", "blocked", "locked", "dropped"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
