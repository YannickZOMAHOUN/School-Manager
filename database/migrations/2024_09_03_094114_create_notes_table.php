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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->float('note');
            $table->float('semester');
            $table->unsignedBigInteger('recording_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('ratio_id');
            $table->foreign('ratio_id')->references('id')->on('ratios')->onDelete('cascade');
            $table->foreign('recording_id')->references('id')->on('recordings')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
