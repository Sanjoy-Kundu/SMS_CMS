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
        Schema::create('grading_scales', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('class_id')->constrained('class_models')->cascadeOnDelete(); 
        $table->string('grade')->nullable();                  // যেমন: A+, A, A-, B, C, D, F
        $table->decimal('gpa', 3, 2)->nullable();             // যেমন: 5.00, 4.00
        $table->integer('min_range')->nullable(); // সর্বনিম্ন range, null allowed
        $table->integer('max_range')->nullable(); // সর্বোচ্চ range, null allowed
        $table->unique(['class_id', 'grade'], 'unique_class_grade');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_scales');
    }
};
