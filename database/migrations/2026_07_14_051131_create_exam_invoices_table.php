<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_invoices', function (Blueprint $table) {
            $table->id();
            // Connect structural context chains upstream
            $table->foreignId('student_enrollment_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_term_id')->constrained()->onDelete('cascade');
            
            // Financial Ledger Values
            $table->decimal('amount_due', 10, 2);
            $table->decimal('amount_paid', 10, 2)->default(0.00);
            $table->enum('status', ['Unpaid', 'Partially Paid', 'Paid'])->default('Unpaid');
            $table->date('due_date');
            $table->date('payment_date')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_invoices');
    }
};