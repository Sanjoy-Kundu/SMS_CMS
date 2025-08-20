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
        Schema::create('teachers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // link with users
        $table->foreignId('institution_id')->constrained('institutions')->cascadeOnDelete();

        // teacher-specific info
        $table->date('joined_at')->nullable();
        $table->boolean('is_active')->default(true);

        // personal info
        $table->string('father_name')->nullable();
        $table->string('mother_name')->nullable();
        $table->string('phone')->unique()->nullable();
        $table->string('address')->nullable();
        $table->string('image')->nullable();
        $table->string('nationality')->nullable();
        $table->date('birth_date')->nullable();
        $table->string('nid')->unique()->nullable();
        $table->enum('gender', ['male', 'female', 'other'])->nullable();
        $table->enum('religion', ['Hindu', 'Muslim', 'Buddhist', 'Christian', 'Other'])->nullable();
        $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();

        // optional: prevent duplicate assignment
        $table->unique(['user_id', 'institution_id']);

        $table->timestamps();
        $table->softDeletes(); // keep history
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
