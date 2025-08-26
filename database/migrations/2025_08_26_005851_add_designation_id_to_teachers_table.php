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
        Schema::table('teachers', function (Blueprint $table) {
           $table->foreignId('designation_id')->nullable()->constrained('designations')->nullOnDelete()->after('institution_id'); //after institution_id 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
        $table->dropForeign(['designation_id']);
        $table->dropColumn('designation_id');
        });
    }
};
