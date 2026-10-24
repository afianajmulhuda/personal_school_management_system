<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('father_name', 100)->nullable();
            $table->string('father_phone', 20)->nullable();
            $table->string('father_profession', 100)->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->string('mother_phone', 20)->nullable();
            $table->string('mother_profession', 100)->nullable();
            $table->string('emergency_contact_name', 100);
            $table->string('emergency_contact_phone', 20);
            $table->string('emergency_relation', 50);
            $table->string('guardian_email', 100)->nullable();
            $table->text('residential_address');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('guardians');
    }
};