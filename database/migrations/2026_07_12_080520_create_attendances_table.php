<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_enrollment_id')->constrained('student_enrollments')->onDelete('cascade');
            $table->date('attendance_date');
            $table->string('status', 10); // PRESENT, ABSENT, LATE, EXCUSED
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('marked_by_user_id')->nullable();
            $table->timestamps();

            $table->unique(['student_enrollment_id', 'attendance_date']);
            $table->index(['attendance_date', 'student_enrollment_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('attendance');
    }
};