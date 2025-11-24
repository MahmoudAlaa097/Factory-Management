<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fault_resolutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fault_report_id')->constrained('fault_reports')->onDelete('cascade');
            $table->foreignId('fault_assignment_id')->constrained('fault_assignments')->onDelete('cascade');
            $table->foreignId('machine_component_id')->nullable()->constrained('machine_components')->onDelete('set null');
            $table->text('fault_description');
            $table->text('action_taken');
            $table->json('parts_used')->nullable();
            $table->integer('time_spent_minutes');
            $table->foreignId('resolved_by')->constrained('employees')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['fault_report_id', 'fault_assignment_id', 'resolved_by']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fault_resolutions');
    }
};
