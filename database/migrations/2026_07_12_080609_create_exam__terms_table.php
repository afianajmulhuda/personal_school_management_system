<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exam_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->string('name', 50);
            $table->integer('weightage')->default(100);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exam_terms');
    }
};