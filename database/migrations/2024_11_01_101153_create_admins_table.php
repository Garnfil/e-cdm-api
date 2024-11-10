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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('avatar')->nullable();
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('contact_no');
            $table->string('address')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->enum('status', ['active', 'inactive', 'locked'])->default('active');
            $table->string('admin_role')->default('admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('admins');
    }
};
