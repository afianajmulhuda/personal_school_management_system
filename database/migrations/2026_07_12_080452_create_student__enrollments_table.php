<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->foreignId('campus_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->integer('roll_no');
            $table->string('enrollment_status', 20)->default('PROMOTED'); // PROMOTED, RETAINED
            $table->timestamps();

            // Guard rails to prevent duplicate roll allocations or dual-year allocations
            $table->unique(['academic_year_id', 'campus_id', 'class_id', 'section_id', 'roll_no'], 'unique_roll_idx');
            $table->unique(['student_id', 'academic_year_id']);
            $table->index(['academic_year_id', 'campus_id', 'class_id'], 'enrollment_lookup_idx');
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_enrollments');
    }
};