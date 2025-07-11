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
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_stream_assignment_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('subject_teacher_1')->nullable();
            $table->unsignedBigInteger('subject_teacher_2')->nullable();
            $table->string('subject_type'); // e.g., 'technical', 'optional', 'mathematics', 'languages', etc.
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('class_stream_assignment_id')
                ->references('id')
                ->on('class_stream_assignments')
                ->onDelete('cascade'); // If an assignment is deleted, delete its subjects

            // Optional: Add unique constraint if a subject can only be of one type per assignment
            // $table->unique(['class_stream_assignment_id', 'subject_id', 'subject_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_subjects');
    }
};
