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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('date_of_birth_AD')->nullable();
            $table->date('date_of_birth_BS');
            $table->string('address');
            $table->foreignId('level_id')->constrained();
            $table->foreignId('batch_id')->constrained();
            $table->integer('phone');
            $table->string('gender');
            $table->integer('roll_no');
            $table->foreignId('classroom_id')->constrained();
            $table->foreignId('caste_id')->constrained();
            $table->foreignId('religion_id')->constrained();
            $table->timestamps();
        });

        Schema::create('student_subject', function (Blueprint $table){
                $table->id();
                $table->foreignId('student_id')->constrained()->onDelete('cascade');
                $table->foreignId('subject_id')->constrained()->onDelete('cascade');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
