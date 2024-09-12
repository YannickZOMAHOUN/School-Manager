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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->enum('sex', ['M', 'F']);
            $table->string('email');
            $table->float('number');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
