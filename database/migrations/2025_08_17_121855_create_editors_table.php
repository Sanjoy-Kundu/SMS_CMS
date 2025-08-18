<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('editors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); //mani editor ID
            $table->foreignId('institution_id')->constrained('institutions')->cascadeOnDelete();

            // future fields
            $table->string('designation')->nullable();
            $table->date('joined_at')->nullable();
            $table->boolean('is_active')->default(true);


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

            // Optional: prevent duplicate assignment
            $table->unique(['user_id', 'institution_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editors');
    }
};
