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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('class_models')->cascadeOnDelete(); // 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12
            $table->foreignId('division_id')->nullable()->constrained('divisions')->cascadeOnDelete(); // science commerece arts
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->string('name'); // Bangla, English, Math
            $table->string('code')->nullable(); // 101, 102, 103
            $table->enum('type', ['compulsory', 'optional', 'additional'])->default('compulsory');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
