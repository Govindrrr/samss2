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
        Schema::create('esetups', function (Blueprint $table) {
            $table->id();
            $table->integer('Tr_full_mark');
            $table->integer('Tr_pass_mark');
            $table->integer('Pr_full_mark');
            $table->integer('Pr_pass_mark');
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('faculty_id')->constrained();
            $table->foreignId('level_id')->constrained();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esetups');
    }
};
