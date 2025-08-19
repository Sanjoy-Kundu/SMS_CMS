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
        Schema::create('editor_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('editor_id')->constrained('editors')->cascadeOnDelete();
            $table->enum('type', ['present', 'permanent']);
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('post_office')->nullable();
            $table->string('postal_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editor_addresses');
    }
};
