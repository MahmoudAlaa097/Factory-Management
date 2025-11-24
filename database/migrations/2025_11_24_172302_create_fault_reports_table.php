<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fault_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique(); // 2024-0001
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->foreignId('machine_id')->constrained('machines')->onDelete('cascade');
            $table->foreignId('machine_section_id')->nullable()->constrained('machine_sections')->onDelete('set null');
            $table->foreignId('reported_by')->constrained('employees')->onDelete('cascade');
            $table->timestamp('reported_at');
            $table->text('notes')->nullable();
            $table->string('fault_type');
            $table->boolean('machine_stopped')->default(false);
            $table->string('status')->default('pending');
            $table->string('priority')->default('normal');
            $table->timestamps();

            $table->index(['division_id', 'machine_id', 'status']);
            $table->index(['report_number', 'fault_type', 'reported_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fault_reports');
    }
};
