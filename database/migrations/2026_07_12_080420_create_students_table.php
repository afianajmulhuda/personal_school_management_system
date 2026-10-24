<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('admission_no', 50)->unique();
            $table->foreignId('campus_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('guardian_id')->constrained()->restrictOnDelete();
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->date('date_of_birth');
            $table->string('gender', 15);
            $table->string('blood_group', 5)->nullable();
            $table->string('nationality', 50)->default('Citizen');
            $table->string('religion', 50)->nullable();
            $table->string('student_phone', 20)->nullable();
            $table->string('student_email', 100)->unique()->nullable();
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->date('registration_date');
            $table->string('status', 20)->default('ACTIVE'); // ACTIVE, DROPPED, GRADUATED
            $table->text('photo_url')->nullable();
            $table->timestamps();
            $table->index(['first_name', 'last_name']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('students');
    }
};