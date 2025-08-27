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
        Schema::create('grades', function (Blueprint $table) {
        $table->id();
        $table->foreignId('institution_id')->constrained('institutions')->cascadeOnDelete();
        $table->foreignId('class_id')->constrained('class_models')->cascadeOnDelete();
        $table->string('grade'); // A+, A, A-, B
        $table->decimal('gpa', 3, 2); // 5.00, 4.00
        $table->integer('min_mark'); // 80
        $table->integer('max_mark'); // 100
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
