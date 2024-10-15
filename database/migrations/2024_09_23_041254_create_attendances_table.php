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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes');
            $table->string('attendance_code');
            $table->foreignId('student_id')->constrained('students');
            $table->dateTime('attendance_datetime');
            $table->timestamps();
        });

        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->constrained('attendances');
            $table->foreignId('student_id')->constrained('students');
            $table->dateTime('attendance_datetime');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('student_attendances');
    }
};
