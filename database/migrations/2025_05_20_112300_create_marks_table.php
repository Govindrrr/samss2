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
      
         Schema::create('marks', function (Blueprint $table) {
        $table->id();
        $table->integer('roll_no');
        $table->double('marks');
        $table->integer('pass_mark');
        $table->integer('full_mark');
        $table->integer('pr_full_mark');
        $table->integer('pr_pass_mark');
        $table->double('pr_marks');
        $table->foreignId('exam_id')->constrained()->onDelete('cascade');
        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->foreignId('level_id')->constrained()->onDelete('cascade');
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->foreignId('classroom_id')->constrained();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
