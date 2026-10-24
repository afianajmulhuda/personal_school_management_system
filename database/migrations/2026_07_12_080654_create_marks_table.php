<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_enrollment_id')->constrained('student_enrollments')->onDelete('cascade');
            $table->decimal('marks_obtained', 5, 2);
            $table->boolean('is_absent')->default(false);
            $table->text('teacher_remarks')->nullable();
            $table->timestamps();

            $table->unique(['exam_id', 'student_enrollment_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('marks');
    }
};