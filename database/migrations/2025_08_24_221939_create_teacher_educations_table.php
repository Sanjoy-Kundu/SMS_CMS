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
        Schema::create('teacher_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->enum('level', ['SSC', 'HSC', 'Graduation', 'Masters'])->nullable();
            $table->string('roll_number')->nullable();
            $table->string('board_university')->nullable();
            $table->string('result')->nullable();
            $table->year('passing_year')->nullable();
            $table->string('course_duration')->nullable(); // Only for Graduation & Masters
            $table->timestamps();
            $table->softDeletes(); // 👈 soft delete column (deleted_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_educations');
    }
};
