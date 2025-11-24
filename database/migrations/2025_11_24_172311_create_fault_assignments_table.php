<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fault_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fault_report_id')->constrained('fault_reports')->onDelete('cascade');
            $table->foreignId('assigned_to_management_id')->constrained('managements')->onDelete('cascade');
            $table->foreignId('assigned_to')->constrained('employees')->onDelete('cascade');
            $table->foreignId('assigned_by')->constrained('employees')->onDelete('cascade');
            $table->timestamp('assigned_at');
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['fault_report_id', 'assigned_to_management_id', 'assigned_to']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fault_assignments');
    }
};
