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
        Schema::create('academic_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institutions')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->enum('section_type', ['school', 'college']);
            $table->string('approval_letter_no')->nullable(); //APL-2023-456
            $table->date('approval_date')->nullable(); //2023-02-15
            $table->string('approval_stage')->nullable(); //fist step, second step
            $table->string('level')->nullable(); // secondary higher secondary
            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_sections');
    }
};
