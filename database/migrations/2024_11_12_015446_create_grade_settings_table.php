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
        Schema::create('grade_settings', function (Blueprint $table) {
            $table->id();
            $table->enum("semester", ['1st', '2nd']);
            $table->enum("assessment_type", ['prelim', 'midterm', 'final']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('grade_settings');
    }
};
