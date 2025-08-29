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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('class_models')->cascadeOnDelete();

            // Main content
            $table->string('title');
            $table->text('description');

            // Priority / Urgency
            $table->enum('priority', ['High', 'Medium', 'Low'])->default('Medium');

            // Attachment / Link
            $table->string('attachment')->nullable();
            $table->string('link')->nullable();

            // Audience and Category
            $table->enum('audience', ['Students','Teachers','All'])->default('Students');
            $table->enum('category', ['Exam','Event','Homework','General'])->default('General');

            // Recurring notice
            $table->enum('recurring', ['None','Daily','Weekly','Monthly'])->default('None');

            // Read status summary
            $table->integer('read_count')->default(0);

            // Active flag
            $table->boolean('is_active')->default(true);

            // Validity
            $table->timestamp('valid_until')->nullable();

            // Timestamps
            $table->timestamps();

            // Soft delete
            $table->softDeletes(); // deleted_at column automatically added
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
